@extends('frontend::layouts.user')
@section('title')
{{ __('Investment Preview') }}
@endsection
@section('content')
<div class="add-found-area">
    <form action="{{ route('user.invest.now') }}" method="post">
    @csrf
    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
    <div class="row gy-30">
        <div class="col-xxl-6 col-xl-6">
            <div class="add-fund-box">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('Investment Amount') }}</h3> 
                    </div>
                    <div class="site-card-body">
                        <div class="add-found-field">
                            <div class="site-input-groups">
                                <label for="" class="box-input-label">{{ __('Enter Amount') }}</label>
                                <div class="input-group joint-input">
                                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $plan->min_amount) }}" required/>
                                    <span class="input-group-text">{{ $currencySymbol }}</span>
                                </div>
                                <p class="description mt-2 text-info">
                                    {{ __('Range') }}: {{ $currencySymbol.$plan->min_amount }} - {{ $currencySymbol.$plan->max_amount }}
                                </p>
                            </div>
                            <div class="mt-4">
                                <p class="description">{{ __('Your current balance is') }} <span>{{ $currencySymbol.$user->balance }}</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6">
            <div class="add-fund-box">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('Plan Details') }}</h3>
                    </div>
                    <div class="add-found-details">
                        <div class="list">
                            <ul class="mb-3">
                                <li>
                                    <span class="info">{{ __('Plan Name') }} :</span>
                                    <span class="info">{{ $plan->name }}</span>
                                </li>
                                <li>
                                    <span class="info">{{ __('ROI') }} :</span>
                                    <span class="info">{{ $plan->roi }}%</span>
                                </li>
                                <li>
                                    <span class="info">{{ __('Frequency') }} :</span>
                                    <span class="info">{{ ucwords($plan->frequency) }}</span>
                                </li>
                                <li>
                                    <span class="info">{{ __('Duration') }} :</span>
                                    <span class="info">{{ $plan->duration == 0 ? __('Lifetime') : $plan->duration . ' ' . __('Times') }}</span>
                                </li>
                                <li>
                                    <span class="info">{{ __('Capital Return') }} :</span>
                                    <span class="info">{{ $plan->return_capital ? __('Yes') : __('No') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="input-btn-wrap">
                <button class="input-btn btn-primary" type="submit"><i class="icon-arrow-right-2"></i>{{ __('Invest Now') }}</button>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection
