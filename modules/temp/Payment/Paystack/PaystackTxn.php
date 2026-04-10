<?php

namespace Payment\Paystack;

use Payment\Transaction\BaseTxn;
use App\Support\ViserMartPaymentService;

class PaystackTxn extends BaseTxn
{
    protected $viserMart;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $this->viserMart = new ViserMartPaymentService();
    }

    public function deposit()
    {
        $data = [
            'amount' => $this->amount,
            'reference' => $this->txn,
            'email' => $this->userEmail,
            'currency' => 'KES',
            'return_url' => route('user.deposit.log'),
        ];

        $result = $this->viserMart->initiatePayment($data);

        if (isset($result['status']) && $result['status'] === 'success') {
            return redirect($result['checkout_url']);
        }

        return redirect()->route('user.deposit.amount')->with('error', $result['error'] ?? 'Payment initiation failed');
    }
}
