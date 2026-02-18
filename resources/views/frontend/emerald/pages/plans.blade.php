@extends('frontend::pages.index')
@section('title')
    {{ $data->title }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')

    @php
        $plans = \App\Models\SubscriptionPlan::all();
    @endphp

    <!-- Subscriptions section start -->
    <section class="subscriptions-section section-space-top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="section-title-wrapper text-center section-title-space">
                        <h2 class="section-title mb-20">{{ $data->plan_choose_title }}</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center gy-30">
                @foreach ($plans as $plan)
                <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                    <div @class([
                        'pricing-item',
                        'popular-plan' => $plan->is_featured,
                        'subscribed' => auth()->check() && $plan->id == auth()->user()->plan_id
                    ])>
                        @if($plan->is_featured)
                        <div class="plan-badge">{{ $plan->badge }}</div>
                        @endif
                        <h3 class="item-title">{{ $plan->name }}</h3>
                        <p class="description">{{ $plan->description }}</p>
                        <div class="price-value">
                            <strong>{{ $currencySymbol.round($plan->price) }}</strong>
                            <sub>/ {{ $plan->validity.' '.__('Days') }}</sub>
                        </div>
                        <div class="price-btn">
                            @if(auth()->check() && $plan->id == auth()->user()->plan_id)
                            <a class="site-btn w-100">{{ __('Subscribed') }}</a>
                            @else
                            <a class="site-btn w-100" href="{{ route('user.subscription.purchase.preview',$plan->id) }}">{{ __('Subscribe Now') }}</a>
                            @endif
                        </div>
                        <div class="price-list">
                            <ul class="icon-list">
                                
                                <li>
                                    <span class="list-item-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 10.08V11C20.9988 13.1564 20.3005 15.2547 19.0093 16.9818C17.7182 18.709 15.9033 19.9725 13.8354 20.5839C11.7674 21.1953 9.55726 21.1219 7.53447 20.3746C5.51168 19.6273 3.78465 18.2461 2.61096 16.4371C1.43727 14.628 0.879791 12.4881 1.02168 10.3363C1.16356 8.18455 1.99721 6.13631 3.39828 4.49706C4.79935 2.85781 6.69279 1.71537 8.79619 1.24013C10.8996 0.764896 13.1003 0.982323 15.07 1.85999"
                                                stroke="#136EF9" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21 3L11 13.01L8 10.01" stroke="#136EF9"
                                                stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <p class="list-item-text">{{ __('Daily Limit') }} : {{ $plan->daily_limit }} {{ __('Ads') }}</p>
                                </li>

                                <li>
                                    <span class="list-item-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 10.08V11C20.9988 13.1564 20.3005 15.2547 19.0093 16.9818C17.7182 18.709 15.9033 19.9725 13.8354 20.5839C11.7674 21.1953 9.55726 21.1219 7.53447 20.3746C5.51168 19.6273 3.78465 18.2461 2.61096 16.4371C1.43727 14.628 0.879791 12.4881 1.02168 10.3363C1.16356 8.18455 1.99721 6.13631 3.39828 4.49706C4.79935 2.85781 6.69279 1.71537 8.79619 1.24013C10.8996 0.764896 13.1003 0.982323 15.07 1.85999"
                                                stroke="#136EF9" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21 3L11 13.01L8 10.01" stroke="#136EF9"
                                                stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <p class="list-item-text">{{ __('Validity') }} : {{ $plan->validity }} {{ __('Days') }}</p>
                                </li>

                                <li>
                                    <span class="list-item-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 10.08V11C20.9988 13.1564 20.3005 15.2547 19.0093 16.9818C17.7182 18.709 15.9033 19.9725 13.8354 20.5839C11.7674 21.1953 9.55726 21.1219 7.53447 20.3746C5.51168 19.6273 3.78465 18.2461 2.61096 16.4371C1.43727 14.628 0.879791 12.4881 1.02168 10.3363C1.16356 8.18455 1.99721 6.13631 3.39828 4.49706C4.79935 2.85781 6.69279 1.71537 8.79619 1.24013C10.8996 0.764896 13.1003 0.982323 15.07 1.85999"
                                                stroke="#136EF9" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21 3L11 13.01L8 10.01" stroke="#136EF9"
                                                stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <p class="list-item-text">{{ __('Withdraw Limit') }} : {{ $plan->withdraw_limit == 0 ? __('Unlimited') : $currencySymbol.$plan->withdraw_limit }}</p>
                                </li>

                                <li>
                                    <span class="list-item-icon">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M21 10.08V11C20.9988 13.1564 20.3005 15.2547 19.0093 16.9818C17.7182 18.709 15.9033 19.9725 13.8354 20.5839C11.7674 21.1953 9.55726 21.1219 7.53447 20.3746C5.51168 19.6273 3.78465 18.2461 2.61096 16.4371C1.43727 14.628 0.879791 12.4881 1.02168 10.3363C1.16356 8.18455 1.99721 6.13631 3.39828 4.49706C4.79935 2.85781 6.69279 1.71537 8.79619 1.24013C10.8996 0.764896 13.1003 0.982323 15.07 1.85999"
                                                stroke="#136EF9" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21 3L11 13.01L8 10.01" stroke="#136EF9"
                                                stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <p class="list-item-text">{{ __('Referral Bonus') }} : {{ __('Upto :level Level',['level' => $plan->referral_level ]) }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Subscriptions section end -->

    <!-- Newsletter section start -->
    @include('frontend::pages.newsletter')
    <!-- Newsletter section end -->
@endsection
