<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    use NotifyTrait;

    public function index()
    {
        $plans = InvestmentPlan::where('status', 1)->latest()->get();
        $currencySymbol = setting('currency_symbol', 'global');
        return view('frontend::user.investment.index', compact('plans', 'currencySymbol'));
    }

    public function history()
    {
        $investments = Investment::with('plan')->where('user_id', auth()->id())->latest()->paginate();
        return view('frontend::user.investment.history', compact('investments'));
    }

    public function purchasePreview(InvestmentPlan $plan)
    {
        $user = auth()->user();
        $currencySymbol = setting('currency_symbol', 'global');
        return view('frontend::user.investment.purchase_now', compact('plan', 'user', 'currencySymbol'));
    }

    public function investNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'plan_id' => 'required|exists:investment_plans,id',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back();
        }

        $plan = InvestmentPlan::findOrFail($request->plan_id);
        $amount = $request->amount;

        if ($amount < $plan->min_amount || $amount > $plan->max_amount) {
            notify()->error(__('Investment amount is out of range.'), 'Error');
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $user = auth()->user();

            if ($user->balance < $amount) {
                notify()->error(__('Insufficient Main Balance.'), 'Error');
                return redirect()->back();
            }

            // Deduct balance
            $user->decrement('balance', $amount);

            // Calculate next return time based on frequency
            $nextReturn = match ($plan->frequency) {
                'hourly' => Carbon::now()->addHour(),
                'daily' => Carbon::now()->addDay(),
                'weekly' => Carbon::now()->addWeek(),
                'monthly' => Carbon::now()->addMonth(),
                'yearly' => Carbon::now()->addYear(),
                default => Carbon::now()->addDay(),
            };

            // Create Investment record
            $investment = Investment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'total_installments' => $plan->duration,
                'next_return_at' => $nextReturn,
                'status' => 'running',
            ]);

            // Create Transaction record
            (new Txn)->new(
                $amount, 
                0, 
                $amount, 
                'system', 
                $plan->name . ' Investment', 
                TxnType::Investment, 
                TxnStatus::Success, 
                null, 
                null, 
                $user->id
            );

            DB::commit();

            notify()->success(__('Invested successfully!'));
            return to_route('user.investments.history');

        } catch (\Exception $e) {
            DB::rollBack();
            notify()->error($e->getMessage());
            return back();
        }
    }
}
