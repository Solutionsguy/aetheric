<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentPlanController extends Controller
{
    public function __construct()
    {
        // You might need to add these permissions to your permissions table if using Spatie
        // $this->middleware('permission:investment-plan-list', ['only' => ['index']]);
        // $this->middleware('permission:investment-plan-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:investment-plan-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:investment-plan-delete', ['only' => ['delete']]);
    }

    public function index()
    {
        $plans = InvestmentPlan::latest()->paginate();
        return view('backend.investment_plan.index', compact('plans'));
    }

    public function create()
    {
        return view('backend.investment_plan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'roi' => 'required|numeric|min:0',
            'frequency' => 'required|string',
            'duration' => 'required|integer|min:0',
            'return_capital' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back()->withInput();
        }

        InvestmentPlan::create($request->all());

        notify()->success(__('Investment plan added successfully!'));
        return to_route('admin.investment.plan.index');
    }

    public function edit($id)
    {
        $plan = InvestmentPlan::findOrFail($id);
        return view('backend.investment_plan.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|min:0',
            'roi' => 'required|numeric|min:0',
            'frequency' => 'required|string',
            'duration' => 'required|integer|min:0',
            'return_capital' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first(), 'Error');
            return redirect()->back()->withInput();
        }

        $plan = InvestmentPlan::findOrFail($id);
        $plan->update($request->all());

        notify()->success(__('Investment plan updated successfully!'));
        return to_route('admin.investment.plan.index');
    }

    public function delete($id)
    {
        InvestmentPlan::destroy($id);
        notify()->success(__('Investment plan deleted successfully!'));
        return to_route('admin.investment.plan.index');
    }
}
