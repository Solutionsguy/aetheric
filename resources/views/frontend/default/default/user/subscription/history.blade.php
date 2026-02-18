@php use App\Enums\TxnStatus; @endphp
@extends('frontend::layouts.user')
@section('title')
{{ __('Subscription History') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('frontend/default/css/daterangepicker.css') }}">
@endpush
@section('content')
<div class="my-ads-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="my-ads-card">
                <div class="site-card">
                    <div class="site-card-header mb-4">
                        <h3 class="site-card-title">{{ __('Subscription History') }}</h3>
                    </div>
                    <div class="site-custom-table-wrapper overflow-x-auto pt-4">
                        <div class="site-custom-table">
                            <div class="contents text-center">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">#</div>
                                    <div class="site-table-col">{{ __('Plan') }}</div>
                                    <div class="site-table-col">{{ __('Amount') }}</div>
                                    <div class="site-table-col">{{ __('Daily Ads Limit') }}</div>
                                    <div class="site-table-col">{{ __('Referral Level') }}</div>
                                    <div class="site-table-col">{{ __('Withdraw Limit') }}</div>
                                    <div class="site-table-col">{{ __('Validity At') }}</div>
                                    <div class="site-table-col">{{ __('Subscribed At') }}</div>
                                    <div class="site-table-col">{{ __('Status') }}</div>
                                </div>
                                @foreach ($histories as $history)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $history->plan->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold green-color">
                                            {{ $currencySymbol.number_format($history->amount,2) }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $history->daily_ads_limit }} {{ __('Ads') }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ __('Upto :level Levels',['level' => $history->referral_level]) }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $currencySymbol.$history->withdraw_limit }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $history->validity_at->format('d M Y h:i A') }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $history->created_at->format('d M Y h:i A') }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($history->status == App\Enums\PlanHistoryStatus::ACTIVE)
                                            <div class="site-badge badge-success">{{ __('Active') }}</div>
                                        @elseif($history->status == App\Enums\PlanHistoryStatus::PENDING)
                                            <div class="site-badge badge-pending">{{ __('Pending') }}</div>
                                        @elseif($history->status == App\Enums\PlanHistoryStatus::EXPIRED)
                                            <div class="site-badge badge-failed">{{ __('Expired') }}</div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($histories) == 0)
                                @include('frontend::user.include.__no_data_found')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{ $histories->links() }}
        </div>
    </div>
</div>
@endsection