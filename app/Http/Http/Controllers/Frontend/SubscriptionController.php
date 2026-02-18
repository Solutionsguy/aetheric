<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\DepositMethod;
use App\Models\PlanHistory;
use App\Models\SubscriptionPlan;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use App\Traits\PlanTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends GatewayController
{
    use ImageUpload, NotifyTrait, PlanTrait;

    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();

        return view('frontend::user.subscription.index', compact('plans'));
    }

    public function history()
    {
        $histories = PlanHistory::with('plan')->where('user_id', auth()->id())->latest()->paginate();

        return view('frontend::user.subscription.history', compact('histories'));
    }

    public function purchasePreview(SubscriptionPlan $plan)
    {
        $gateways = DepositMethod::where('status', 1)->get();

        return view('frontend::user.subscription.purchase_now', compact('plan', 'gateways'));
    }

    public function subscriptionNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'method' => 'required|in:balance,gateway',
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        try {

            DB::beginTransaction();

            $user = $request->user();
            $plan = SubscriptionPlan::findOrFail($request->plan_id);
            $planPrice = $plan->price;
            $payMethod = $request->get('method', 'balance');

            if ($payMethod == 'balance' && $user->balance < $planPrice) {
                notify()->error(__('Insufficent Balance.'), 'Error');

                return redirect()->back();
            }

            if ($payMethod == 'balance') {
                $user->decrement('balance', $planPrice);
            } else {

                $gatewayInfo = DepositMethod::code($request->get('gateway_code'))->first();
                $charge = $gatewayInfo->charge_type == 'percentage' ? (($gatewayInfo->charge / 100) * $planPrice) : $gatewayInfo->charge;
                $finalAmount = (float) $planPrice + (float) $charge;
                $payAmount = $finalAmount * $gatewayInfo->rate;
                $payCurrency = $gatewayInfo->currency;

                $manualData = null;

                if ($request->manual_data != null && is_array($request->manual_data)) {
                    $manualData = $request->manual_data ?? [];
                    foreach ($manualData as $key => $value) {
                        if (is_file($value)) {
                            $manualData[$key] = self::imageUploadTrait($value);
                        }
                    }
                }

                $txnInfo = (new Txn)->new($planPrice, $charge, $finalAmount, $gatewayInfo->name, $plan->name.' Purchased', TxnType::PlanPurchased, TxnStatus::Pending, $payCurrency, $payAmount, $user->id, null, 'User', $manualData ?? [], planId: $plan->id);
                DB::commit();

                return self::depositAutoGateway($request->get('gateway_code'), $txnInfo);
            }

            // Execute plan purchase process
            $txnInfo = (new Txn)->new($planPrice, 0, $planPrice, 'system', $plan->name.' Purchased', TxnType::PlanPurchased, TxnStatus::Success, null, null, $user->id, planId: $plan->id);
            $this->executePlanPurchaseProcess($user, $plan, $txnInfo);

            $shortcodes = [
                '[[full_name]]' => auth()->user()->full_name,
                '[[username]]' => auth()->user()->full_name,
                '[[plan_name]]' => $plan->name,
                '[[amount]]' => $planPrice,
                '[[subscribed_at]]' => $txnInfo->created_at,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->pushNotify('plan_subscribed', $shortcodes, route('admin.transactions'), auth()->id(), 'Admin');
            $this->pushNotify('plan_subscribed', $shortcodes, route('user.transactions'), $txnInfo->user_id);
            $this->mailNotify($txnInfo->user->email, 'plan_subscribed', $shortcodes);

            DB::commit();

            notify()->success(__('Plan purchased successfully!'));

            return to_route('user.transactions');
        } catch (\Throwable $th) {
            DB::rollBack();
            notify()->error($th->getMessage());

            return back();
        }
    }
}
