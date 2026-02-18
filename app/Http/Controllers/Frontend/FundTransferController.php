<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FundTransferController extends Controller
{
    use NotifyTrait;

    public function index()
    {

        if (! setting('kyc_fund_transfer', 'kyc') && (auth()->user()->kyc == 0 || auth()->user()->kyc == 2)) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        return view('frontend::user.fund_transfer.index');
    }

    public function history()
    {
        $from_date = trim(@explode('-', request('daterange'))[0]);
        $to_date = trim(@explode('-', request('daterange'))[1]);

        $histories = Transaction::with('fromUser')
            ->search(request('trx'))
            ->when(request('daterange'), function ($query) use ($from_date, $to_date) {
                $query->whereDate('created_at', '>=', Carbon::parse($from_date)->format('Y-m-d'));
                $query->whereDate('created_at', '<=', Carbon::parse($to_date)->format('Y-m-d'));
            })
            ->own()
            ->where('type', TxnType::FundTransfer)
            ->paginate();

        return view('frontend::user.fund_transfer.history', compact('histories'));
    }

    public function transfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'amount' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $fromUser = Auth::user();
        $toUser = User::where('email', $request->get('email'))->first();

        if (! $toUser) {
            notify()->error(__('User Not Found'), 'Error');

            return redirect()->back();
        }

        $amount = $request->float('amount');

        $chargeType = setting('fund_transfer_charge_type', 'fee');

        $charge = setting('fund_transfer_charge', 'fee');

        if ($chargeType == 'percentage') {
            $charge = $amount * ($charge / 100);
        }

        $totalAmount = $amount + $charge;

        if ($fromUser->balance < $amount) {
            notify()->error(__('Insufficient Balance'));

            return redirect()->back();
        }

        $fromUser->decrement('balance', $totalAmount);
        $sendDescription = 'Transfer Money To '.$toUser->username;
        (new Txn)->new($amount, $charge, $totalAmount, 'system', $sendDescription, TxnType::FundTransfer, TxnStatus::Success, null, null, $fromUser->id, $toUser->id);

        $toUser->increment('balance', $amount);
        $receiveDescription = 'Transfer Money Form '.$fromUser->username;
        $txnInfo = (new Txn)->new($amount, $charge, $totalAmount, 'system', $receiveDescription, TxnType::ReceivedMoney, TxnStatus::Success, null, null, $toUser->id, $fromUser->id, 'User', []);

        $shortcodes = [
            '[[full_name]]' => auth()->user()->full_name,
            '[[email]]' => auth()->user()->email,
            '[[charge]]' => $txnInfo->charge,
            '[[amount]]' => $txnInfo->amount,
            '[[total_amount]]' => $txnInfo->final_amount,
            '[[receiver_name]]' => $toUser->full_name,
            '[[site_title]]' => setting('site_title', 'global'),
            '[[site_url]]' => route('home'),
        ];

        $this->pushNotify('fund_transfer_request', $shortcodes, route('admin.transactions'), auth()->id(), 'Admin');
        $this->mailNotify($txnInfo->user->email, 'fund_transfer_request', $shortcodes);
        $this->smsNotify('fund_transfer_request', $shortcodes, $txnInfo->user->phone);

        notify()->success('Fund transfer has been successful!');

        return to_route('user.fund_transfer.history');
    }
}
