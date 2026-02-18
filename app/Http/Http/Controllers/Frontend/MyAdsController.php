<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\AdsStatus;
use App\Enums\TxnStatus;
use App\Enums\TxnType;
use App\Facades\Txn\Txn;
use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\SubscriptionPlan;
use App\Traits\ImageUpload;
use App\Traits\NotifyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MyAdsController extends Controller
{
    use ImageUpload,NotifyTrait;

    public function index()
    {
        $ads = Ads::query()
            ->user()
            ->when(request('query') != null, function ($query) {
                $query->where('title', 'LIKE', '%'.request('query').'%');
            })
            ->when(request('status') != null, function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('type') != null, function ($query) {
                $query->where('type', request('type'));
            })
            ->latest()
            ->paginate()
            ->withQueryString();

        return view('frontend::user.ads.my-ads', compact('ads'));
    }

    public function create()
    {
        $plans = SubscriptionPlan::get(['id', 'name']);

        return view('frontend::user.ads.create', compact('plans'));
    }

    public function store(Request $request)
    {
        if (! setting('user_ads_post', 'permission')) {
            notify()->error(__('Ads post unavailable!'));

            return to_route('user.ads.index');
        }

        $planWise = setting('ads_system', 'permission') == 1 ? true : false;

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'type' => 'required|in:link,image,script,youtube',
            'link' => 'required_if:type,link',
            'script' => 'required_if:type,script',
            'image' => 'required_if:type,image',
            'youtube' => 'required_if:type,youtube',
            'plan_id' => [Rule::requiredIf($planWise), 'exists:subscription_plans,id'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());

            return redirect()->back()->withInput();
        }

        $bannerPath = null;
        $user = $request->user();

        if ($request->get('type') == 'image' && $request->hasFile('image')) {
            $bannerPath = self::imageUploadTrait($request->file('image'));
        }

        $amountForAds = match ($request->type) {
            'link' => setting('link_ads_price', 'fee'),
            'script' => setting('script_ads_price', 'fee'),
            'image' => setting('image_ads_price', 'fee'),
            'youtube' => setting('youtube_ads_price', 'fee'),
        };

        $finalAmount = $request->max_show_limit * $amountForAds;

        if ($finalAmount > $user->balance) {
            notify()->error(__('Insufficent Balance.'));

            return redirect()->back();
        }

        $amount = match ($request->type) {
            'link' => setting('link_ads_amount', 'fee'),
            'script' => setting('script_ads_amount', 'fee'),
            'image' => setting('image_ads_amount', 'fee'),
            'youtube' => setting('youtube_ads_amount', 'fee'),
        };

        try {

            DB::beginTransaction();

            $schedules = collect($request->schedules)->map(function ($schedule) {
                $schedule['start_time'] = date('H:m', strtotime($schedule['start_time']));
                $schedule['end_time'] = date('H:m', strtotime($schedule['end_time']));

                return $schedule;
            })->toArray();

            $user->decrement('balance', $finalAmount);

            $ads = Ads::create([
                'title' => $request->get('title'),
                'user_id' => auth()->id(),
                'plan_id' => $planWise ? $request->get('plan_id') : null,
                'amount' => $amount,
                'duration' => $request->get('duration'),
                'max_views' => $request->get('max_show_limit'),
                'remaining_views' => $request->get('max_show_limit'),
                'type' => $request->get('type'),
                'value' => $request->get('type') == 'image' ? $bannerPath : $request->get($request->get('type')),
                'schedules' => $schedules,
                'status' => setting('ads_auto_approval', 'permission') ? AdsStatus::Active : AdsStatus::Pending,
            ]);

            $txnInfo = (new Txn)->new(
                $finalAmount,
                0,
                $finalAmount,
                'System',
                'Ads Posted',
                TxnType::AdsPosted,
                TxnStatus::Success,
                null,
                null,
                $user->id,
            );

            DB::commit();

            $shortcodes = [
                '[[full_name]]' => auth()->user()->full_name,
                '[[username]]' => auth()->user()->full_name,
                '[[ads_title]]' => $ads->title,
                '[[status]]' => $ads->status->value,
                '[[site_title]]' => setting('site_title', 'global'),
                '[[site_url]]' => route('home'),
            ];

            $this->pushNotify('ads_post', $shortcodes, route('admin.ads.edit', $ads->id), auth()->id(), 'Admin');
            $this->mailNotify($txnInfo->user->email, 'ads_post', $shortcodes);

            notify()->success(__('Ads submitted successfully!'));

            return to_route('user.my.ads.index');

        } catch (\Throwable $th) {
            notify()->error(__('Sorry, something went wrong!'));

            return to_route('user.my.ads.index');
        }
    }

    public function edit($id)
    {
        $ads = Ads::findOrFail(decrypt($id));
        $plans = SubscriptionPlan::get(['id', 'name']);

        return view('frontend::user.ads.edit', compact('ads', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $planWise = setting('ads_system', 'permission') == 1 ? true : false;

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required_if:type,link',
            'script' => 'required_if:type,script',
            'image' => 'required_if:type,image',
            'youtube' => 'required_if:type,youtube',
            'plan_id' => [Rule::requiredIf($planWise), 'exists:subscription_plans,id'],
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());

            return redirect()->back()->withInput();
        }

        $ads = Ads::findOrFail(decrypt($id));

        $bannerPath = null;

        if ($request->get('type') == 'image' && $request->hasFile('image')) {
            $bannerPath = self::imageUploadTrait($request->file('image'));
        }

        $ads->update([
            'title' => $request->get('title'),
            'plan_id' => $planWise ? $request->get('plan_id') : null,
            'duration' => $request->get('duration'),
            'value' => $ads->type->value == 'image' ? $bannerPath ?? $ads->value : $request->get($ads->type->value),
        ]);

        notify()->success(__('Ads updated successfully!'));

        return to_route('user.my.ads.index');
    }
}
