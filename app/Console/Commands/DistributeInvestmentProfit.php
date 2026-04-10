<?php

namespace App\Console\Commands;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\Investment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DistributeInvestmentProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investment:distribute-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute profits to users with active investments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $investments = Investment::where('status', 'running')
            ->where('next_return_at', '<=', Carbon::now())
            ->get();

        foreach ($investments as $investment) {
            $this->distributeProfit($investment);
        }

        $this->info('Investment profits distributed successfully.');
    }

    private function distributeProfit(Investment $investment)
    {
        try {
            DB::beginTransaction();

            $plan = $investment->plan;
            $user = $investment->user;
            
            // Calculate profit amount
            $profit = ($investment->amount * $plan->roi) / 100;

            // Update user balance
            $user->increment('balance', $profit);

            // Update investment record
            $investment->increment('total_profit', $profit);
            $investment->increment('installments_paid');
            $investment->last_return_at = Carbon::now();

            // Calculate next return time
            $nextReturn = match ($plan->frequency) {
                'hourly' => Carbon::now()->addHour(),
                'daily' => Carbon::now()->addDay(),
                'weekly' => Carbon::now()->addWeek(),
                'monthly' => Carbon::now()->addMonth(),
                'yearly' => Carbon::now()->addYear(),
                default => Carbon::now()->addDay(),
            };

            // Check if investment is completed
            if ($plan->duration > 0 && $investment->installments_paid >= $plan->duration) {
                $investment->status = 'completed';
                $investment->next_return_at = null;

                // Return capital if enabled
                if ($plan->return_capital) {
                    $user->increment('balance', $investment->amount);
                    
                    // Log Capital Return Transaction
                    (new Txn)->new(
                        $investment->amount,
                        0,
                        $investment->amount,
                        'system',
                        $plan->name . ' Capital Return',
                        TxnType::Refund,
                        TxnStatus::Success,
                        null,
                        null,
                        $user->id
                    );
                }
            } else {
                $investment->next_return_at = $nextReturn;
            }

            $investment->save();

            // Log Profit Transaction
            (new Txn)->new(
                $profit,
                0,
                $profit,
                'system',
                $plan->name . ' Investment Profit',
                TxnType::InvestmentProfit,
                TxnStatus::Success,
                null,
                null,
                $user->id
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to distribute profit for investment ID: {$investment->id}. Error: " . $e->getMessage());
        }
    }
}
