@extends('backend.layouts.app')
@section('title')
    {{ __('Add Plan') }}
@endsection
@section('content')
<div class="main-content">
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="title-content">
                        <h2 class="title">{{ __('Add Plan') }}</h2>
                        <a href="{{ route('admin.subscription.plan.index') }}" class="title-btn"><i data-lucide="arrow-left"></i>{{ __('Back') }}</a>
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
                        <form action="{{ route('admin.subscription.plan.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Name') }}</label>
                                        <input type="text" name="name" class="box-input mb-0" value="{{ old('name') }}" required/>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Description') }}</label>
                                        <input type="text" name="description" class="box-input mb-0" value="{{ old('description') }}" required/>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Daily Ads Limit') }}</label>
                                        <input type="text" name="daily_limit" class="box-input mb-0" value="{{ old('daily_limit') }}" required/>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Price') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="price" class="form-control" value="{{ old('price') }}"/>
                                            <span class="input-group-text">{{ $currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Validity') }}</label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="validity" class="form-control" value="{{ old('validity') }}"/>
                                            <span class="input-group-text">{{ __('Days') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Withdraw Limit') }} <i data-lucide="info" data-bs-toggle="tooltip" data-bs-original-title="Enter 0 if you don't need withdraw limit"></i></label>
                                        <div class="input-group joint-input">
                                            <input type="number" name="withdraw_limit" class="form-control" value="{{ old('withdraw_limit',0) }}"/>
                                            <span class="input-group-text">{{ $currency }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Referral Commission') }}</label>
                                        <select name="referral_level" class="form-select">
                                            <option selected disabled>{{ __('Select Commission Level') }}</option>
                                            <option value="0">{{ __('No Referral Commission') }}</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->the_order }}" @selected(old('referral_level') == $level->the_order)>{{ __('Upto :level Level',['level' => $level->the_order]) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Featured') }}</label>
                                        <div class="switch-field same-type">
                                            <input type="radio" id="radio-five" name="featured" value="1" @checked(old('featured') == 1)/>
                                            <label for="radio-five">{{ __('Yes') }}</label>
                                            <input type="radio" id="radio-six" name="featured"value="0" @checked(old('featured',0) == 0)/>
                                            <label for="radio-six">{{ __('No') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4" id="badgeArea">
                                    <div class="site-input-groups">
                                        <label for="" class="box-input-label">{{ __('Badge') }}</label>
                                        <input type="text" name="badge" class="box-input mb-0" value="{{ old('badge') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="action-btns">
                                <button type="submit" class="site-btn-sm primary-btn me-2">
                                    <i data-lucide="check"></i>
                                    {{ __('Add Plan') }}
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

@section('script')
    <script>
        (function ($) {
            "use strict";

            toggleBadgeVisibility();
            
            function toggleBadgeVisibility()
            {
                var featured = $('input[name="featured"]:checked').val();
                if (featured === '1') {
                    $('#badgeArea').show();
                } else {
                    $('#badgeArea').hide();
                }
            }
            
            $('input[name="featured"]').on('change', function () {
                toggleBadgeVisibility();
            });

        })(jQuery);
    </script>
@endsection
