<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Support\ViserMartPaymentService;
use App\Traits\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ViserMartWebhookController extends Controller
{
    use Payment;

    protected $service;

    public function __construct(ViserMartPaymentService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle ViserMart Webhook
     */
    public function handle(Request $request)
    {
        file_put_contents(base_path('webhook_test.log'), date('Y-m-d H:i:s') . " - Webhook received\n", FILE_APPEND);
        $signature = $request->header('X-Aetheric-Signature');
        $payload = $request->all();

        if (!$signature || !$this->service->verifySignature($payload, $signature)) {
            Log::warning('Unauthorized ViserMart Webhook attempt', ['sig' => $signature]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $reference = $payload['external_reference'];
        $status = $payload['status'];

        if ($status !== 'paid') {
            return response()->json(['status' => 'ignored']);
        }

        // Find the transaction in SolidNew
        $txn = Transaction::tnx($reference);

        if (!$txn) {
            Log::error('Transaction not found for ViserMart webhook', ['ref' => $reference]);
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($txn->status->value == 'success') { 
            return response()->json(['status' => 'already_processed']);
        }

        try {
            Log::info('Processing ViserMart payment confirmation', ['ref' => $reference]);
            $this->paymentSuccess($reference, false);
        } catch (\Exception $e) {
            Log::error('Error processing ViserMart payment', [
                'ref' => $reference,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Internal processing error'], 500);
        }

        return response()->json(['status' => 'success']);
    }
}