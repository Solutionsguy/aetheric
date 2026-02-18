<?php

namespace App\Http\Controllers;

use App\Enums\PlanHistoryStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Models\AdsHistory;
use App\Models\CronJob;
use App\Models\CronJobLog;
use App\Models\PlanHistory;
use App\Models\User;
use App\Traits\NotifyTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Remotelywork\Installer\Repository\App;

class CronJobController extends Controller
{
    use NotifyTrait;

    public function runCronJobs()
    {

        $action_id = request('run_action');

        // Get running cron jobs
        if (is_null($action_id)) {
            $jobs = CronJob::where('status', 'running')
                ->where('next_run_at', '<', now())
                ->get();
        } else {
            $jobs = CronJob::whereKey($action_id)->get();
        }

        foreach ($jobs as $job) {

            $error = null;

            $log = new CronJobLog();
            $log->cron_job_id = $job->id;
            $log->started_at = now();

            try {

                if ($job->type == 'system') {
                    $this->{$job->reserved_method}();
                } else {
                    Http::withOptions([
                        'verify' => false,
                    ])->get($job->url);
                }
            } catch (\Throwable $th) {
                $error = $th->getMessage();
            }

            $log->ended_at = now();
            $log->error = $error;
            $log->save();

            $job->update([
                'last_run_at' => now(),
                'next_run_at' => now()->addSeconds($job->schedule),
            ]);
        }

        if ($action_id !== null) {
            notify()->success(__('Cron running successfully!'), 'Success');

            return back();
        }
    }

    public function adsBonusClaim()
    {
        $pendingBonuses = AdsHistory::with('ads', 'customer')
            ->where('is_claimed', false)
            ->where('claimable_at', '<=', now())
            ->get();
        try {
            DB::beginTransaction();

            foreach ($pendingBonuses as $bonus) {

                $ads = $bonus->ads;

                $user = $bonus->customer;
                $user->increment('balance', $ads->amount);

                (new Txn)->new($ads->amount, 0, $ads->amount, 'System', 'Ads Viewed - '.$ads->title, TxnType::AdsViewed, TxnStatus::Success, userID: $bonus->user_id);

                $bonus->update([
                    'is_claimed' => true,
                ]);
            }

            DB::commit();

            return '........bonus claimed successfully.';
        } catch (\Throwable $th) {
            DB::rollBack();

            return $th->getMessage();
        }
    }

    public function planSubscription()
    {
        // Get all expired plans
        $expiredPlans = PlanHistory::with('plan')->where('status', PlanHistoryStatus::ACTIVE)->where('validity_at', '<=', now())->get();

        try {
            DB::beginTransaction();

            // Loop through the expired plans
            foreach ($expiredPlans as $plan) {

                // Shortcodes for the notification
                $shortcodes = [
                    '[[plan_name]]' => $plan->plan?->name,
                    '[[expired_at]]' => $plan->validity_at,
                ];

                // Update the plan status
                $plan->update([
                    'status' => PlanHistoryStatus::EXPIRED,
                ]);

                // Notify the user about the expired plan
                $this->pushNotify('plan_expired', $shortcodes, route('user.dashboard'), $plan->user_id);
            }

            DB::commit();

            return '........expired users plan successfully.';
        } catch (\Throwable $th) {
            DB::rollBack();

            return $th->getMessage();
        }
    }

    public function userInactive()
    {
        if (! setting('inactive_account_disabled', 'inactive_user') == 1) {
            return false;
        }

        try {

            DB::beginTransaction();
            $this->startCron();

            User::whereDoesntHave('activities', function ($query) {
                $query->where('created_at', '>', now()->subDays(30));
            })->where('status', 1)->chunk(500, function ($inactiveUsers) {
                foreach ($inactiveUsers as $user) {
                    $user->update(['status' => 0]);
                    $shortcodes = [
                        '[[full_name]]' => $user->full_name,
                        '[[site_title]]' => setting('site_title', 'global'),
                        '[[site_url]]' => route('home'),
                        '[[inactive_days]]' => setting('inactive_days', 'inactive_user'),
                    ];
                    $this->mailNotify($user->email, 'user_account_disabled', $shortcodes);
                }
            });

            DB::commit();

            return '........Inactive users disabled successfully.';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    protected function startCron()
    {
        if (! App::initApp()) {
            return false;
        }
    }
}
