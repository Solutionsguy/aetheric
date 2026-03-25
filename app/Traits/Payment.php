<?php

namespace App\Traits;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\DepositMethod;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Payment\Binance\BinanceTxn;
use Payment\Blockchain\BlockchainTxn;
use Payment\BlockIo\BlockIoTxn;
use Payment\Btcpayserver\BtcpayserverTxn;
use Payment\Cashmaal\CashmaalTxn;
use Payment\Coinbase\CoinbaseTxn;
use Payment\Coingate\CoingateTxn;
use Payment\Coinpayments\CoinpaymentsTxn;
use Payment\Coinremitter\CoinremitterTxn;
use Payment\Cryptomus\CryptomusTxn;
use Payment\Flutterwave\FlutterwaveTxn;
use Payment\Instamojo\InstamojoTxn;
use Payment\Mollie\MollieTxn;
use Payment\Monnify\MonnifyTxn;
use Payment\Nowpayments\NowpaymentsTxn;
use Payment\Paymongo\PaymongoTxn;
use Payment\Paypal\PaypalTxn;
use Payment\Paystack\PaystackTxn;
use Payment\Paytm\PaytmTxn;
use Payment\Perfectmoney\PerfectmoneyTxn;
use Payment\Razorpay\RazorpayTxn;
use Payment\Securionpay\SecurionpayTxn;
use Payment\Stripe\StripeTxn;
use Payment\Twocheckout\TwocheckoutTxn;
use Payment\Voguepay\VoguepayTxn;

trait Payment
{
    use PlanTrait;

    protected function depositAutoGateway($gateway, $txnInfo)
    {
        $txn = $txnInfo->tnx;
        \Illuminate\Support\Facades\Log::info('depositAutoGateway called', ['gateway_input' => $gateway, 'txn' => $txn]);
        Session::put('deposit_tnx', $txn);
        $gatewayMethod = DepositMethod::code($gateway)->first();
        $gatewayCode = $gatewayMethod->gateway->gateway_code ?? 'none';
        \Illuminate\Support\Facades\Log::info('Resolved gateway code', ['code' => $gatewayCode]);

        $gatewayTxn = self::gatewayMap($gatewayCode, $txnInfo);
        if ($gatewayTxn) {
            \Illuminate\Support\Facades\Log::info('Found gateway transaction class', ['class' => get_class($gatewayTxn)]);
            return $gatewayTxn->deposit();
        }

        \Illuminate\Support\Facades\Log::warning('No gateway transaction class found for code', ['code' => $gatewayCode]);
        return self::paymentNotify($txn, 'pending');
    }

    protected function withdrawAutoGateway($gatewayCode, $txnInfo)
    {
        $gatewayTxn = self::gatewayMap($gatewayCode, $txnInfo);
        if ($gatewayTxn && config('app.demo') == 0) {
            $gatewayTxn->withdraw();
        }

        return redirect()->route('user.withdraw.log');
    }

    protected function paymentNotify($tnx, $status)
    {
        $tnxInfo = Transaction::tnx($tnx);

        $status = ucfirst($status);

        if ($status == 'Success' && $tnxInfo->type == TxnType::PlanPurchased) {
            $plan = SubscriptionPlan::find($tnxInfo->plan_id);
            $this->executePlanPurchaseProcess($tnxInfo->user, $plan, $tnxInfo);
        }

        if ($status == 'Pending') {

            $shortcodes = [
                '[[full_name]]' => $tnxInfo->user->full_name,
                '[[txn]]' => $tnxInfo->tnx,
                '[[gateway_name]]' => $tnxInfo->method,
                '[[deposit_amount]]' => $tnxInfo->amount,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
                '[[message]]' => '',
                '[[status]]' => $status,
            ];

            $this->mailNotify(setting('site_email', 'global'), 'manual_deposit_request', $shortcodes);
            $this->pushNotify('manual_deposit_request', $shortcodes, route('admin.deposit.manual.pending'), $tnxInfo->user->id, 'Admin');
            $this->smsNotify('manual_deposit_request', $shortcodes, $tnxInfo->user->phone);
        }

        return to_route('user.transactions');
    }

    protected function paymentSuccess($ref, $isRedirect = true)
    {
        $txnInfo = Transaction::tnx($ref);

        if ($txnInfo->status == TxnStatus::Success) {
            return false;
        }

        (new Txn)->update($ref, TxnStatus::Success, $txnInfo->user_id);

        // If this transaction was a subscription plan purchase via an automatic gateway,
        // we must activate/record the plan here as well (paymentNotify() is bypassed).
        if ($txnInfo->type == TxnType::PlanPurchased) {
            $plan = SubscriptionPlan::find($txnInfo->plan_id);
            if ($plan) {
                $this->executePlanPurchaseProcess($txnInfo->user, $plan, $txnInfo);
            }
        }

        // Deposit referral bounty: pay only for actual deposits.
        // If you also want plan purchases to be treated as deposits, we handle that below.
       /*
        if (setting('deposit_level') && ($txnInfo->type == TxnType::Deposit || $txnInfo->type == TxnType::ManualDeposit)) {
            $level = getReferralLevel($txnInfo->user_id);
            creditReferralBonus($txnInfo->user, 'deposit', $txnInfo->amount, $level);
        }

        // Optional: treat subscription purchases as a deposit action for referral bounty.
        // This allows deposit-level referral to work for both wallet and gateway plan purchases.
        // To avoid double-paying, we only do this when subscription_plan_level is OFF.
        if ($txnInfo->type == TxnType::PlanPurchased && setting('deposit_level') && ! setting('subscription_plan_level')) {
            $level = getReferralLevel($txnInfo->user_id);
            creditReferralBonus($txnInfo->user, 'deposit', $txnInfo->amount, $level);
        }
        */

        if ($isRedirect) {
            return redirect(URL::temporarySignedRoute(
                'status.success',
                now()->addMinutes(2)
            ));
        }
    }

    //automatic gateway map snippet
    private function gatewayMap($gateway, $txnInfo)
    {
        $gatewayMap = [
            'paypal' => PaypalTxn::class,
            'stripe' => StripeTxn::class,
            'mollie' => MollieTxn::class,
            'perfectmoney' => PerfectmoneyTxn::class,
            'coinbase' => CoinbaseTxn::class,
            'paystack' => PaystackTxn::class,
            'voguepay' => VoguepayTxn::class,
            'flutterwave' => FlutterwaveTxn::class,
            'cryptomus' => CryptomusTxn::class,
            'nowpayments' => NowpaymentsTxn::class,
            'securionpay' => SecurionpayTxn::class,
            'coingate' => CoingateTxn::class,
            'monnify' => MonnifyTxn::class,
            'coinpayments' => CoinpaymentsTxn::class,
            'paymongo' => PaymongoTxn::class,
            'coinremitter' => CoinremitterTxn::class,
            'btcpayserver' => BtcpayserverTxn::class,
            'binance' => BinanceTxn::class,
            'cashmaal' => CashmaalTxn::class,
            'blockio' => BlockIoTxn::class,
            'blockchain' => BlockchainTxn::class,
            'instamojo' => InstamojoTxn::class,
            'paytm' => PaytmTxn::class,
            'razorpay' => RazorpayTxn::class,
            'twocheckout' => TwocheckoutTxn::class,
        ];

        if (array_key_exists($gateway, $gatewayMap)) {
            return app($gatewayMap[$gateway], ['txnInfo' => $txnInfo]);
        }

        return false;
    }
}
