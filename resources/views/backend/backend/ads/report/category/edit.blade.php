@extends('backend.layouts.app')
@section('title')
    {{ __('Update Report Category') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Update Report Category') }}</h2>
                        <a href="{{ route('admin.ads.report.category.index') }}" class="title-btn"><i data-lucide="arrow-left"></i>{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="site-card">
                    <div class="site-card-body">
                        <form action="{{ route('admin.ads.report.category.update',$category->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-12">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Name') }}</label>
                                        <input type="text" name="name" class="box-input mb-0" value="{{ $category->name }}" required/>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Status') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-five" name="status" value="1" @checked($category->status == '1')/>
                                            <label for="radio-five">{{ __('Active') }}</label>
                                            <input type="radio" id="radio-six" name="status" value="0" @checked($category->status == '0')/>
                                            <label for="radio-six">{{ __('Inactive') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Update Report Category') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
