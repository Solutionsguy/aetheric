<?php

namespace App\Traits;

use App\Enums\PlanHistoryStatus;
use App\Models\PlanHistory;

trait PlanTrait
{
    public function executePlanPurchaseProcess($user, $plan, $transaction = null)
    {
        // Check if the user already has an active plan of the same id
        $existingPlanHistory = PlanHistory::where('user_id', $user->id)
            ->where('plan_id', $plan->id)
            ->where('status', PlanHistoryStatus::ACTIVE)
            ->first();

        if ($existingPlanHistory) {
            // Extend the limits and validity of the existing plan
            $existingPlanHistory->daily_ads_limit += $plan->daily_limit;
            $existingPlanHistory->referral_level += $plan->referral_level;
            $existingPlanHistory->withdraw_limit += $plan->withdraw_limit;
            $existingPlanHistory->validity_at = now()->parse($existingPlanHistory->validity_at)->addDays($plan->validity);
            $existingPlanHistory->save();
        } else {
            // Create a new plan history record if no active plan exists
            PlanHistory::create([
                'plan_id' => $plan->id,
                'user_id' => $user->id,
                'daily_ads_limit' => $plan->daily_limit,
                'referral_level' => $plan->referral_level,
                'withdraw_limit' => $plan->withdraw_limit,
                'amount' => $plan->price,
                'validity_at' => now()->addDays($plan->validity),
                'status' => PlanHistoryStatus::ACTIVE,
            ]);
        }

        // Credit referral bonus if enabled
        if (setting('subscription_plan_level') && $transaction !== null) {
            $level = getReferralLevel($transaction->user_id);
            creditReferralBonus($transaction->user, 'subscription_plan', $transaction->amount, $level);
        }
    }
}
