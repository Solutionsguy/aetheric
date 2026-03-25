<?php

use App\Models\Transaction;
use App\Enums\TxnType;
use App\Enums\TxnStatus;
use App\Support\ViserMartPaymentService;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$reference = 'TRX_' . strtoupper(bin2hex(random_bytes(5)));
echo "Creating transaction $reference in SolidNew...\n";

$txn = new Transaction();
$txn->user_id = 1; // Assuming user ID 1 exists
$txn->amount = 10;
$txn->charge = 0;
$txn->final_amount = 10;
$txn->method = 'ViserMart';
$txn->description = 'Test Payment via ViserMart';
$txn->type = TxnType::Deposit;
$txn->status = TxnStatus::Pending;
$txn->tnx = $reference;
$txn->save();

$service = new ViserMartPaymentService();

$data = [
    'reference' => $reference,
    'amount' => 10,
    'currency' => 'KES',
    'email' => 'test@example.com',
    'callback_url' => 'http://localhost/solidnew/ipn/visermart',
    'return_url' => 'http://localhost/solidnew/return',
];

echo "Initiating payment on ViserMart...\n";
$result = $service->initiatePayment($data);

print_r($result);
