<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ViserMartPaymentService
{
    protected $baseUrl;
    protected $apiKey;
    protected $webhookSecret;

    public function __construct()
    {
        $this->baseUrl = config('services.visermart.base_url');
        $this->apiKey = config('services.visermart.api_key');
        $this->webhookSecret = config('services.visermart.webhook_secret');
    }

    /**
     * Initiate payment on ViserMart
     */
    public function initiatePayment($data)
    {
        try {
            $response = Http::timeout(5)->withHeaders([
                'X-Aetheric-Key' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/api/external/payment/initiate', [
                'external_reference' => $data['reference'],
                'amount' => $data['amount'],
                'currency' => $data['currency'],
                'customer_email' => $data['email'],
                'callback_url' => $data['callback_url'] ?? route('ipn.visermart'),
                'return_url' => $data['return_url'] ?? null,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('ViserMart payment initiation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'data' => $data
            ]);

            return ['error' => 'Could not initiate payment with ViserMart'];
        } catch (\Exception $e) {
            Log::error('Exception during ViserMart payment initiation', [
                'message' => $e->getMessage()
            ]);
            return ['error' => 'Payment service connection error'];
        }
    }

    /**
     * Verify ViserMart Webhook Signature
     */
    public function verifySignature($payload, $signature)
    {
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $this->webhookSecret);
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Check payment status via ViserMart API
     */
    public function checkPaymentStatus($externalReference)
    {
        try {
            $response = Http::timeout(3)->withHeaders([
                'X-Aetheric-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/api/external/payment/status/' . $externalReference);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('ViserMart status check failed', [
                'ref' => $externalReference,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return ['error' => 'Status check failed'];
        } catch (\Exception $e) {
            Log::error('Exception checking ViserMart status', [
                'ref' => $externalReference,
                'error' => $e->getMessage()
            ]);
            return ['error' => $e->getMessage()];
        }
    }
}