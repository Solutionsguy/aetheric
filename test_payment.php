<?php

use App\Support\ViserMartPaymentService;
use Illuminate\Support\Facades\Http;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$service = new ViserMartPaymentService();

$data = [
    'reference' => 'TEST_' . time(),
    'amount' => 10,
    'currency' => 'KES',
    'email' => 'test@example.com',
    'callback_url' => 'http://localhost/solidnew/ipn/visermart',
    'return_url' => 'http://localhost/solidnew/return',
];

echo "Initiating payment...\n";
$result = $service->initiatePayment($data);

print_r($result);
