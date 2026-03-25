<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Models\DepositMethod;
use App\Models\Transaction;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Txn;

class DepositController extends GatewayController
{
    use ImageUpload, NotifyTrait;

    public function deposit()
    {
        if (! setting('user_deposit', 'permission') || ! Auth::user()->deposit_status) {
            notify()->error(__('Deposit currently unavailable'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_deposit', 'kyc') && (auth()->user()->kyc == 0 || auth()->user()->kyc == 2)) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $isStepOne = 'current';
        $isStepTwo = '';
        $gateways = DepositMethod::where('status', 1)->get();

        return view('frontend::deposit.now', compact('isStepOne', 'isStepTwo', 'gateways'));
    }

    public function depositNow(Request $request)
    {

        if (! setting('user_deposit', 'permission') || ! Auth::user()->deposit_status) {
            notify()->error(__('Deposit currently unavailable!'), 'Error');

            return to_route('user.dashboard');
        } elseif (! setting('kyc_deposit') && ! auth()->user()->kyc) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $validator = Validator::make($request->all(), [
            'gateway_code' => 'required',
            'amount' => ['required', 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back();
        }

        $input = $request->all();

        $gatewayInfo = DepositMethod::code($input['gateway_code'])->first();
        $amount = $input['amount'];

        if ($amount < $gatewayInfo->minimum_deposit || $amount > $gatewayInfo->maximum_deposit) {
            $currencySymbol = setting('currency_symbol', 'global');
            $message = 'Please Deposit the Amount within the range '.$currencySymbol.$gatewayInfo->minimum_deposit.' to '.$currencySymbol.$gatewayInfo->maximum_deposit;
            notify()->error($message, 'Error');

            return redirect()->back();
        }

        $charge = $gatewayInfo->charge_type == 'percentage' ? (($gatewayInfo->charge / 100) * $amount) : $gatewayInfo->charge;
        $finalAmount = (float) $amount + (float) $charge;
        $payAmount = $finalAmount * $gatewayInfo->rate;
        $depositType = TxnType::Deposit;

        if (isset($input['manual_data'])) {

            $depositType = TxnType::ManualDeposit;
            $manualData = $input['manual_data'];

            foreach ($manualData as $key => $value) {

                if (is_file($value)) {
                    $manualData[$key] = self::imageUploadTrait($value);
                }
            }
        }

        $txnInfo = Txn::new($input['amount'], $charge, $finalAmount, $gatewayInfo->gateway_code, 'Deposit With '.$gatewayInfo->name, $depositType, TxnStatus::Pending, $gatewayInfo->currency, $payAmount, auth()->id(), null, 'User', $manualData ?? []);

        return self::depositAutoGateway($gatewayInfo->gateway_code, $txnInfo);
    }

    public function depositSuccess(Request $request)
    {
        // Handle return from ViserMart payment
        $status = $request->get('status');
        $reference = $request->get('reference');

        if ($reference && $status === 'paid') {
            // Verify the transaction was processed
            $txn = Transaction::tnx($reference);
            if ($txn && $txn->status->value !== 'success') {
                // Trigger payment success processing
                try {
                    $this->paymentSuccess($reference, false);
                    notify()->success(__('Payment completed successfully!'), 'Success');
                } catch (\Exception $e) {
                    Log::error('Error processing ViserMart return callback', [
                        'ref' => $reference,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return view('frontend::deposit.success');
    }

    public function depositLog(Request $request)
    {
        $from_date = trim(@explode('-', request('daterange'))[0]);
        $to_date = trim(@explode('-', request('daterange'))[1]);

        // Auto-verify pending ViserMart payments BEFORE fetching deposits
        $this->autoVerifyPendingViserMartPayments();

        $deposits = Transaction::where('user_id', auth()->user()->id)
            ->search(request('trx'))
            ->whereIn('type', [TxnType::Deposit, TxnType::ManualDeposit])
            ->when(request('daterange'), function ($query) use ($from_date, $to_date) {
                $query->whereDate('created_at', '>=', Carbon::parse($from_date)->format('Y-m-d'));
                $query->whereDate('created_at', '<=', Carbon::parse($to_date)->format('Y-m-d'));
            })->latest()->paginate(request('limit', 15))->withQueryString();

        // Check if this is a return from ViserMart payment
        $status = $request->get('status');
        $reference = $request->get('reference');
        if ($reference && $status === 'paid') {
            notify()->success(__('Payment completed successfully!'), 'Success');
        }

        return view('frontend::deposit.log', compact('deposits'));
    }

    /**
     * Auto-verify pending ViserMart payments
     * This handles cases where webhooks couldn't reach localhost
     */
    protected function autoVerifyPendingViserMartPayments()
    {
        $pendingDeposits = Transaction::where('user_id', auth()->user()->id)
            ->where('status', TxnStatus::Pending)
            ->where('type', TxnType::Deposit)
            ->where('method', 'paystack') // ViserMart uses Paystack gateway
            ->where('created_at', '>', now()->subHours(24)) // Only check recent transactions
            ->get();

        foreach ($pendingDeposits as $deposit) {
            try {
                // Check status via ViserMart API
                $viserMart = new \App\Support\ViserMartPaymentService();
                $status = $viserMart->checkPaymentStatus($deposit->tnx);

                if (isset($status['status']) && $status['status'] === 'paid') {
                    $this->paymentSuccess($deposit->tnx, false);
                    Log::info('Auto-verified ViserMart payment', ['ref' => $deposit->tnx]);
                }
            } catch (\Exception $e) {
                Log::error('Error auto-verifying ViserMart payment', [
                    'ref' => $deposit->tnx,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
