<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackVerifyController extends Controller
{
    use Payment;

    /**
     * Handle Paystack return and verify payment
     */
    public function verify(Request $request)
    {
        // Get transaction reference from Paystack callback
        // Paystack sends back: ?trxref=xxx or ?reference=xxx
        $reference = $request->query('trxref') ?? $request->query('reference');
        
        \Log::info('Paystack return handler', [
            'query' => $request->all(),
            'reference' => $reference
        ]);
        
        if (!$reference) {
            return redirect()->route('status.cancel')
                ->with('error', 'No transaction reference found in callback');
        }

        try {
            // Method 1: Try using Paystack package getPaymentData (reads from request)
            if ($request->has('trxref')) {
                $paymentDetails = Paystack::getPaymentData();
                
                \Log::info('Paystack getPaymentData result', ['details' => $paymentDetails]);
                
                if ($paymentDetails['data']['status'] === 'success') {
                    $transactionId = $paymentDetails['data']['reference'];
                    return self::paymentSuccess($transactionId);
                }
            }
            
            // Method 2: Manual API verification
            $secretKey = config('paystack.secretKey');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ])->get('https://api.paystack.co/transaction/verify/' . $reference);
            
            \Log::info('Paystack manual verify response', ['body' => $response->body()]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] && $data['data']['status'] === 'success') {
                    return self::paymentSuccess($reference);
                }
                
                return redirect()->route('status.cancel')
                    ->with('error', 'Payment not successful: ' . ($data['data']['gateway_response'] ?? 'Unknown'));
            }
            
        } catch (\Exception $e) {
            \Log::error('Paystack verify error', ['error' => $e->getMessage()]);
        }

        return redirect()->route('status.cancel')
            ->with('error', 'Payment verification failed. If payment was deducted, please contact support.');
    }
}
