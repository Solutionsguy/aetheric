<?php

namespace App\Http\Controllers\Backend;

use App\Enums\ReferralType;
use App\Http\Controllers\Controller;
use App\Models\LevelReferral;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:plan-list', ['only' => ['index']]);
        $this->middleware('permission:plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plan-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        $plans = SubscriptionPlan::latest()->paginate();

        return view('backend.subscription_plan.index', compact('plans'));
    }

    public function create()
    {
        $levels = LevelReferral::where('type', ReferralType::SubscriptionPlan->value)->orderBy('the_order')->get();

        return view('backend.subscription_plan.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'daily_limit' => 'required|numeric',
            'price' => 'required|numeric',
            'validity' => 'required|numeric',
            'withdraw_limit' => 'required|numeric',
            'referral_level' => 'required|numeric',
            'badge' => 'required_if:featured,true',
            'featured' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back()->withInput();
        }

        SubscriptionPlan::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'daily_limit' => $request->get('daily_limit'),
            'price' => $request->get('price'),
            'validity' => $request->get('validity'),
            'withdraw_limit' => $request->get('withdraw_limit'),
            'referral_level' => $request->get('referral_level'),
            'badge' => $request->boolean('featured') ? $request->get('badge') : '',
            'is_featured' => $request->boolean('featured'),
        ]);

        notify()->success(__('Subscription plan added successfully!'));

        return to_route('admin.subscription.plan.index');
    }

    public function edit($id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $levels = LevelReferral::where('type', ReferralType::SubscriptionPlan->value)->orderBy('the_order')->get();

        return view('backend.subscription_plan.edit', compact('plan', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'daily_limit' => 'required|numeric',
            'price' => 'required|numeric',
            'validity' => 'required|numeric',
            'withdraw_limit' => 'required|numeric',
            'referral_level' => 'required|numeric',
            'badge' => 'required_if:featured,true',
            'featured' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');

            return redirect()->back()->withInput();
        }

        SubscriptionPlan::findOrFail($id)->update([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'daily_limit' => $request->get('daily_limit'),
            'price' => $request->get('price'),
            'validity' => $request->get('validity'),
            'withdraw_limit' => $request->get('withdraw_limit'),
            'referral_level' => $request->get('referral_level'),
            'badge' => $request->boolean('featured') ? $request->get('badge') : '',
            'is_featured' => $request->boolean('featured'),
        ]);

        notify()->success(__('Subscription plan added successfully!'));

        return to_route('admin.subscription.plan.index');
    }

    public function delete($id)
    {
        SubscriptionPlan::destroy($id);
        notify()->success(__('Subscription plan deleted successfully!'));

        return to_route('admin.subscription.plan.index');
    }
}
