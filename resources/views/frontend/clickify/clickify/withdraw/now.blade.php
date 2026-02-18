@extends('frontend::layouts.user')
@section('title')
{{ __('Withdraw Now') }}
@endsection
@section('content')
<div class="withdraw-area">
    <div class="site-card-header">
        <div class="site-title-inner">
            <h3 class="site-card-title mb-0">{{ __('Withdraw Money') }}</h3>
            <div class="d-flex">
                <a class="site-btn primary-btn me-2" href="{{ route('user.withdraw.log') }}"><i class="icon-receipt-item"></i>{{ __('Withdraw History') }}</a>
                <a class="site-btn primary-btn" href="{{ route('user.withdraw.account.index') }}"><i class="icon-directbox-send"></i>{{ __('Withdraw Account') }}</a>
            </div>
        </div>
    </div>
    <div class="withdraw-content-wrap">
        <div class="site-card">
            <form action="{{ route('user.withdraw.now') }}" method="POST">
                @csrf
                <div class="row gy-30">
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="withdraw-form">
                            <div class="single-input">
                                <label class="input-label" for="">{{ __('Withdraw Account') }}</label>
                                <div class="input-select">
                                    <select name="withdraw_account" id="withdrawAccountId">
                                        <option selected disabled>{{ __('Select Account') }}</option>
                                        @foreach($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->method_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-danger processing-time mt-2"></div>
                            </div>
                            <div class="single-input has-right-icon">
                                <label class="input-label" for="">{{ __('Amount') }}</label>
                                <div class="input-field">
                                    <input type="text" name="amount" class="box-input">
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
                                <div class="text-danger range mt-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="add-found-details">
                            <div class="list">
                                <ul>
                                    
                                    <li>
                                        <span class="info">{{ __('Amount') }}:</span>
                                        <span class="info amount"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Charge') }}:</span>
                                        <span class="info charge"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Payment Method') }}:</span>
                                        <span class="info method"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Payment Method Logo') }}:</span>
                                        <span class="thumb">
                                            <img src="" class="method-logo">
                                        </span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Conversion Rate') }}:</span>
                                        <span class="info conversion-rate"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Total') }}:</span>
                                        <span class="info text-danger pay-amount"></span>
                                    </li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="button-inner">
                            <div class="input-btn-wrap">
                                <button class="input-btn btn-primary" type="submit"><i class="icon-arrow-right-2"></i>{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    "use strict";

    var currency = @json($currency);
    var info = [];

    $('.method').hide();

    $("select[name=withdraw_account]").on('change', function (e) {
        e.preventDefault();

        $('.selectDetailsTbody').children().not(':first', ':second').remove();
        var accountId = $(this).val()
        var amount = $('input[name=amount]').val();

        if (!isNaN(accountId)) {
            var url = '{{ route("user.withdraw.details",["accountId" => ":accountId", "amount" => ":amount"]) }}';
            url = url.replace(':accountId', accountId, );
            url = url.replace(':amount', amount);

            $.get(url, function (data) {
                $(data.html).insertAfter(".detailsCol");
                info = data.info;
                $('.range').text(info.range);
                $('.processing-time').text(info.processing_time);
                $('.method').html('<span class="type site-badge badge-primary">' + info.name +
                    '</span>');
                $('.method').show();
                $('.method-logo').attr('src',info.logo);
            })
        }

    })

    $("input[name=amount]").on('keyup', function (e) {
        "use strict"
        e.preventDefault();
        var amount = $(this).val()
        var charge = info.charge_type === 'percentage' ? calPercentage(amount, info.charge) : info.charge
        $('.amount').text(amount + ' ' + currency)
        $('.charge').text('-' + charge + ' ' + currency)
        $('.processing-time').text(info.processing_time)
        $('.conversion-rate').text('1' + ' ' + currency + ' = ' + info.rate + ' ' + info.pay_currency)
        $('.range').text(info.range)
        $('.pay-amount').text(amount * info.rate + ' ' + info.pay_currency)
    });

</script>
@endpush
