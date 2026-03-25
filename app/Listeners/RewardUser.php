<?php

namespace App\Listeners;

use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Events\UserReferred;
use App\Models\ReferralLink;
use App\Models\ReferralRelationship;
use App\Models\User;
use Txn;

class RewardUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserReferred $event)
    {
        $referral = ReferralLink::find($event->referralId);
        if (! is_null($referral)) {
            ReferralRelationship::create(['referral_link_id' => $referral->id, 'user_id' => $event->user->id]);

            User::find($event->user->id)->update([
                'ref_id' => $referral->user->id,
            ]);

            $email_verification = setting('email_verification', 'permission') ? $referral->user->email_verified_at !== null : true;

            // Signup referral bonus removed:
            // This project now uses level-based referral rewards (percentage of deposits/subscriptions)
            // via creditReferralBonus() instead of a fixed signup bonus.
        }
    }
}
