<?php

namespace App\Console\Commands;

use App\Facades\Txn\Txn;
use App\Models\Transaction;
use App\Enums\TxnStatus;
use Illuminate\Console\Command;

class FixPaystackDeposit extends Command
{
    protected $signature = 'deposit:fix {reference=TRXEOYTZYUA2L} {--auto : Auto confirm without prompt}';
    protected $description = 'Fix a deposit that was verified by Paystack but marked as failed';

    public function handle()
    {
        $reference = $this->argument('reference');
        
        $transaction = Transaction::tnx($reference);
        
        if (!$transaction) {
            $this->error("Transaction {$reference} not found!");
            return 1;
        }
        
        $this->info("Transaction found: {$transaction->tnx}");
        $this->info("Current status: {$transaction->status->value}");
        $this->info("Amount: {$transaction->amount}");
        $this->info("User: {$transaction->user->email}");
        $this->info("Current deposit_balance: " . $transaction->user->deposit_balance);
        
        if ($transaction->status == TxnStatus::Success) {
            $this->warn("Transaction already marked as successful!");
            $this->info("Current deposit_balance: " . $transaction->user->deposit_balance);
            return 0;
        }
        
        if ($this->option('auto') || $this->confirm("Mark this transaction as successful?")) {
            // Update transaction status
            (new Txn)->update($reference, TxnStatus::Success, $transaction->user_id);
            
            // Reload to get updated data
            $transaction->refresh();
            $transaction->user->refresh();
            
            $this->info("✅ Transaction updated successfully!");
            $this->info("New status: {$transaction->status->value}");
            $this->info("New deposit_balance: " . $transaction->user->deposit_balance);
            
            return 0;
        }
        
        return 0;
    }
}
