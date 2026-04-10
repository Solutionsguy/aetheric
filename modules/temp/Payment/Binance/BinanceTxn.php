<?php

namespace Payment\Binance;

use App\Enums\TxnStatus;
use App\Models\User;
use Binance\API;
use Payment\Transaction\BaseTxn;
use Illuminate\Support\Facades\Log;
use Txn;

class BinanceTxn extends BaseTxn
{
    private $apiKey;
    private $apiSecret;

    public function __construct($txnInfo)
    {
        parent::__construct($txnInfo);
        $gatewayInfo = gateway_info('binance');
        
        if (!$gatewayInfo) {
            Log::error('Binance gateway info not found for gateway_code: binance');
            $this->apiKey = null;
            $this->apiSecret = null;
        } else {
            $this->apiKey = $gatewayInfo->api_key ?? null;
            $this->apiSecret = $gatewayInfo->api_secret ?? null;
        }
    }

    public function deposit()
    {
        Log::info('Binance Pay Deposit Initiated', ['txn' => $this->txn, 'amount' => $this->amount]);

        if (!$this->apiKey || !$this->apiSecret) {
            Log::error('Binance Pay Error: Missing API Key or Secret Key');
            notify()->error('Binance Pay Error: Missing API configuration.');
            return redirect()->back();
        }

        // Use a more secure nonce generation
        try {
            $nonce = bin2hex(random_bytes(16)); 
        } catch (\Exception $e) {
            $nonce = Str::random(32);
        }
        
        $timestamp = round(microtime(true) * 1000);

        $request = [
            'env' => ['terminalType' => 'WEB'],
            'merchantTradeNo' => $this->txn . '_' . $timestamp, // Ensure uniqueness
            'orderAmount' => (float) $this->amount,
            'currency' => $this->currency,
            'goods' => [
                'goodsType' => '01',
                'goodsCategory' => 'D000',
                'referenceGoodsId' => $this->txn,
                'goodsName' => "Deposit " . $this->txn,
                'goodsDetail' => "Payment for transaction " . $this->txn,
            ],
        ];

        $json_request = json_encode($request);
        $payload = $timestamp . "\n" . $nonce . "\n" . $json_request . "\n";
        $signature = strtoupper(hash_hmac('SHA512', $payload, $this->apiSecret));

        $headers = [
            'Content-Type: application/json',
            "BinancePay-Timestamp: $timestamp",
            "BinancePay-Nonce: $nonce",
            "BinancePay-Certificate-SN: {$this->apiKey}",
            "BinancePay-Signature: $signature",
        ];

        Log::info('Binance Pay Request Payload', ['payload' => $request]);

        $ch = curl_init('https://bpay.binanceapi.com/binancepay/openapi/v2/order');
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $json_request,
            CURLOPT_TIMEOUT => 30,
        ]);

        $result = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            Log::error('Binance Pay Curl Error', ['error' => $curlError]);
            notify()->error('Binance Pay Error: Connection failed.');
            return redirect()->back();
        }

        Log::info('Binance Pay Raw Response', ['response' => $result]);
        $response = json_decode($result);

        if (isset($response->status) && $response->status === 'SUCCESS' && isset($response->data->checkoutUrl)) {
            return redirect()->to($response->data->checkoutUrl);
        }

        $errorMessage = $response->errorMessage ?? $response->msg ?? 'Invalid Response from Binance';
        Log::error('Binance Pay API Error', ['response' => $response]);
        
        notify()->error('Binance Pay Error: ' . $errorMessage);
        return redirect()->back();
    }

    public function withdraw()
    {
        Log::info('Binance Withdraw Initiated', ['txn' => $this->txn, 'amount' => $this->amount]);
        
        if (!$this->apiKey || !$this->apiSecret) {
            Log::error('Binance Withdraw Error: Missing API Key or Secret Key');
            return;
        }

        $asset = $this->currency;
        $address = $this->paymentAddress ?? $this->txnInfo->payment_address ?? null; 
        $amount = $this->amount;

        if (!$address) {
            Log::error('Binance Withdraw Error: Missing withdrawal address');
            return;
        }

        // Initialize the SDK correctly
        // Note: php-binance-api.php must be included if not autoloaded
        $apiFile = __DIR__ . '/php-binance-api.php';
        if (file_exists($apiFile)) {
            require_once $apiFile;
        }

        if (!class_exists('Binance\API')) {
            Log::error('Binance API class not found');
            return;
        }

        $api = new API($this->apiKey, $this->apiSecret);
        
        try {
            $response = $api->withdraw($asset, $address, $amount);

            if (isset($response['id']) || (isset($response['success']) && $response['success'])) {
                Txn::update($this->txn, TxnStatus::Success, $this->userId);
                Log::info('Binance Withdraw Success', ['txn' => $this->txn]);
            } else {
                throw new \Exception($response['msg'] ?? 'Binance API Error');
            }
        } catch (\Exception $e) {
            $user = User::find($this->userId);
            if ($user) {
                $user->increment('balance', $this->final_amount);
            }
            Txn::update($this->txn, TxnStatus::Failed, $this->userId);
            Log::error('Binance Withdrawal Failed', ['error' => $e->getMessage()]);
            notify()->error('Withdrawal Failed: ' . $e->getMessage());
        }
    }
}
