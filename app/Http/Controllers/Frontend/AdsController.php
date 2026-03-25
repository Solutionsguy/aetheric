<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\AdsStatus;
use App\Enums\PlanHistoryStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\AdsHistory;
use App\Models\AdsReport;
use App\Models\AdsReportCategory;
use App\Models\PlanHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdsController extends Controller
{
    public function index()
    {
        if (! setting('kyc_ads', 'kyc') && (auth()->user()->kyc == 0 || auth()->user()->kyc == 2)) {
            notify()->error(__('Please verify your KYC.'), 'Error');

            return to_route('user.dashboard');
        }

        $ads = Ads::active()->when(filled(request('type')), function ($query) {
            $query->where('type', request('type'));
        })->forUser()->where('remaining_views', '>', 0)->get()->filter(function ($ads) {
            return $ads->isScheduledNow();
        });

        return view('frontend::user.ads.index', compact('ads'));
    }

    public function adsView($id)
    {
        // Check daily ads limit
        $plan_id = $this->checkDailyAdsLimit();
        if ($plan_id == null) {
            return redirect()->back();
        }

        // Get ads
        $ads = Ads::findOrFail(decrypt($id));
        $firstInt = rand(1, 20);
        $secondInt = rand(1, 20);

        // Get categories
        $categories = AdsReportCategory::where('status', 1)->get();
        // Check if the user has viewed the ads in the last 24 hours
        $recentlyViewed = AdsHistory::user()->where('ads_id', $ads->id)->where('created_at', '>=', now()->subHours(24))->exists();

        // If the user has viewed the ads in the last 24 hours, show an error message
        if ($recentlyViewed) {
            notify()->error(__('Please wait 24 Hours before viewing ads'));

            return to_route('user.ads.index');
        }

        // Return the view with the ads, first integer, categories, and second integer
        return view('frontend::user.ads.view', compact('ads', 'firstInt', 'categories', 'secondInt'));
    }

    public function adsSubmit(Request $request, $id)
    {
        // Decrypt the ads ID
        $adsId = decrypt($id);

        // Check daily ads limit
        $plan_id = $this->checkDailyAdsLimit();

        // Check if the user has viewed the ads in the last 24 hours
        $recentlyViewed = AdsHistory::user()->where('ads_id', $adsId)->where('created_at', '>=', now()->subHours(24))->exists();

        // If the user has viewed the ads in the last 24 hours, show an error message
        if ($recentlyViewed) {
            notify()->error(__('Please wait 24 Hours before viewing ads'));

            return to_route('user.ads.index');
        }

        // Validate the request
        $firstInt = $request->integer('first_number');
        $secondInt = $request->integer('seconds_number');

        $finalResult = $firstInt + $secondInt;

        // Check if the calculation is correct
        if ($finalResult !== $request->integer('result')) {
            notify()->error(__('Invalid calculation'));

            return redirect()->back();
        }

        // Get the ads
        $ads = Ads::where('status', AdsStatus::Active)->findOrFail($adsId);
        // Get the ads bonus type and delay hours
        $adsBonusType = setting('ads_bonus_system', 'ads');
        $delayHours = setting('ads_bonus_delay_hours', 'ads');
        $adsBonusType = setting('ads_bonus_system', 'ads');
        $delayHours = setting('ads_bonus_delay_hours', 'ads');

        // Store ads history
        AdsHistory::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan_id,
            'ads_id' => $adsId,
            'amount' => $ads->amount,
            'claimable_at' => $adsBonusType ? null : Carbon::now()->addHours($delayHours),
            'is_claimed' => $adsBonusType ? true : false,
            'amount' => $ads->amount,
            'claimable_at' => $adsBonusType ? null : Carbon::now()->addHours($delayHours),
            'is_claimed' => $adsBonusType ? true : false,
        ]);

        // Increment views
        $ads->increment('total_views');
        $ads->decrement('remaining_views');

        if ($adsBonusType) {
            // Credit to User
            $user = $request->user();
            // Ads earnings are part of the main balance (deposit + ads earnings)
            $user->increment('ads_balance', $ads->amount);
            $user->increment('balance', $ads->amount);

            // Add Transaction
            (new Txn)->new($ads->amount, 0, $ads->amount, 'System', 'Ads Viewed - '.$ads->title, TxnType::AdsViewed, TxnStatus::Success);
        }

        notify()->success(__('Ads viewed successfully'));

        return to_route('user.ads.index');
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'description' => 'required',
        ]);

        AdsReport::create([
            'user_id' => auth()->id(),
            'ads_id' => decrypt($request->id),
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        notify()->success(__('Ads reported successfully'));

        return to_route('user.ads.index');
    }

    protected function checkDailyAdsLimit()
    {
        // Get the user ID
        $userId = auth()->id();

        // Get the free user daily limit
        $freeUserDailyLimit = (int) setting('ads_limit_free_user', 'ads');

        // Check if the user has active paid plans
        $activePlans = PlanHistory::where('user_id', $userId)
            ->where('status', PlanHistoryStatus::ACTIVE)
            ->get();

        if ($activePlans->isEmpty()) {
            // Handle free user limits if no active paid plan is found
            $freeUserAdViewCount = AdsHistory::where('user_id', $userId)
                ->where('plan_id', 0)
                ->whereDate('created_at', now())
                ->count();

            // Check if the user has exceeded the daily limit
            if ($freeUserAdViewCount >= $freeUserDailyLimit) {
                notify()->error(__('Daily ads limit exceeded'));

                return null;
            }

            return 0;
        }

        // Check if the user has exceeded the daily limit for any of the active plans
        foreach ($activePlans as $plan) {
            $adViewCount = AdsHistory::where('user_id', $userId)
                ->where('plan_id', $plan->id)
                ->whereDate('created_at', now()->toDateString())
                ->count();

            if ($adViewCount < $plan->daily_ads_limit) {
                return $plan->id;
            }
        }

        notify()->error(__('Daily ads limit exceeded'));

        return null;
    }
}
