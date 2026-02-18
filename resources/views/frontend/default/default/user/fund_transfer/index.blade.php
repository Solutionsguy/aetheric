@extends('frontend::layouts.user')
@section('title')
{{ __('Fund Transfer') }}
@endsection
@section('content')
<div class="ads-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <h3 class="site-card-title mb-0">@yield('title')</h3>
                        <a class="site-btn primary-btn" href="{{ route('user.fund_transfer.history') }}"><i
                                class="icon-receipt-item"></i>{{ __('Fund Transfer History') }}</a>
                    </div>
                </div>
                <div class="create-ads">
                    <form action="{{ route('user.fund_transfer.transfer') }}" method="post">
                        @csrf
                        <div class="row gy-20">
                            <div class="col-xxl-6">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                    <div class="input-field">
                                        <input type="email" class="box-input" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Amount') }}<span class="text-danger">*</span></label>
                                    <div class="input-field">
                                        <input type="text" class="box-input" name="amount">
                                        <span class="icon">
                                            <svg width="10" height="16" viewBox="0 0 10 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M1 10.7177C1 12.2227 2.155 13.436 3.59 13.436H6.51833C7.76667 13.436 8.78167 12.3743 8.78167 11.0677C8.78167 9.64435 8.16333 9.14268 7.24167 8.81602L2.54 7.18268C1.61833 6.85602 1 6.35435 1 4.93102C1 3.62435 2.015 2.56268 3.26333 2.56268H6.19167C7.62667 2.56268 8.78167 3.77602 8.78167 5.28102"
                                                    stroke="#5C5958" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M4.88281 1V15" stroke="#5C5958" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="text-content">
                                        <p class="note">{{ $currencySymbol }}<span class="charges">0</span> {{ __('will be deduct from your account') }}.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12">
                                <div class="input-btn-wrap">
                                    <button class="input-btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#fundTransferDetails"><i class="icon-send-2"></i>{{ __('Send') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    "use strict";

    var chargeType = @json(setting('fund_transfer_charge_type','fee'));
    var charge = @json(setting('fund_transfer_charge','fee'));

    $('input[name=amount]').on('keyup', function() {
        var amount = $(this).val();
        var finalCharge = chargeType == 'percentage' ? (charge / 100) * amount : charge;
        $('.charges').text(finalCharge);

    });

</script>
@endpush