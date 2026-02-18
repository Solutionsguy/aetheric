<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdsReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdsReportCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ads-report-category-list', ['only' => ['index']]);
        $this->middleware('permission:ads-report-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ads-report-category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ads-report-category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = AdsReportCategory::latest()->paginate();

        return view('backend.ads.report.category.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.ads.report.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());

            return redirect()->back()->withInput();
        }

        AdsReportCategory::create([
            'name' => $request->get('name'),
            'status' => $request->boolean('status'),
        ]);

        notify()->success(__('Report category added successfully!'));

        return to_route('admin.ads.report.category.index');
    }

    public function edit($id)
    {
        $category = AdsReportCategory::findOrFail($id);

        return view('backend.ads.report.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors()->first());

            return redirect()->back()->withInput();
        }

        $category = AdsReportCategory::findOrFail($id);

        $category->update([
            'name' => $request->get('name'),
            'status' => $request->boolean('status'),
        ]);

        notify()->success(__('Report category updated successfully!'));

        return to_route('admin.ads.report.category.index');
    }

    public function destroy($id)
    {
        $category = AdsReportCategory::findOrFail($id);
        $category->delete();

        notify()->success(__('Report category deleted successfully!'));

        return to_route('admin.ads.report.category.index');
    }
}
