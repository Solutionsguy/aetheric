@extends('frontend::layouts.user')
@section('title')
{{ __('Deposit Now') }}
@endsection
@section('content')
<div class="add-found-area">
    <form action="{{ route('user.deposit.now') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row gy-30">
            <div class="col-xxl-6 col-xl-6">
                <div class="add-fund-box">
                    <div class="site-card">
                        <div class="site-card-header">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                                <h3 class="site-card-title mb-0">{{ __('Add Fund') }}</h3>
                                <a class="site-btn primary-btn" href="{{ route('user.deposit.log') }}">
                                    <i class="icon-receipt-item"></i>{{ __('History') }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="add-found-wrapper">
                            <div class="add-gateway">
                                <div class="select-gateway">
                                    <div id="gatewayContent" class="select-gateway-item">
                                        <h4 class="title">{{ __('Select Gateway') }}</h4>
                                        <div class="add-gateway-grid">
                                            @foreach ($gateways as $gateway)
                                            <label class="add-gateway-item" for="{{ $gateway->gateway_code }}">
                                                <input type="radio" name="gateway_code" id="{{ $gateway->gateway_code }}" value="{{ $gateway->gateway_code }}">
                                                <div class="add-gateway-thumb">
                                                    <img src="{{ asset($gateway->logo) }}" alt="{{ $gateway->name }}">
                                                </div>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="add-found-field">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Amount') }}</label>
                                    <div class="input-field">
                                        <input type="text" class="box-input" name="amount" id="amount">
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
                                </div>
                                <div class="manual-row"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6">
                <div class="add-fund-box">
                    <div class="site-card">
                        <div class="site-card-header">
                            <h3 class="site-card-title">{{ __('Review Details') }}</h3>
                        </div>
                        <div class="add-found-details">
                            <div class="list">
                                <ul>
                                    <li>
                                        <span class="info">{{ __('Amount') }}:</span>
                                        <span class="amount"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Charge') }}:</span>
                                        <span class="info charge2"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Payment Method') }}:</span>
                                        <span class="info method"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Payment Method Logo') }}:</span>
                                        <span class="balance-thumb" id="logo">
                                            <img src="">
                                        </span>
                                    </li>
                                    <li class="conversion">
                                        <span class="info">{{ __('Conversion Rate') }} :</span>
                                        <span class="info conversion-rate"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Total') }}:</span>
                                        <span class="info total"></span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Payable Amount') }} :</span>
                                        <span class="info pay-amount"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="input-btn-wrap">
                <button class="input-btn btn-primary mt-3" type="submit"><i class="icon-arrow-right-2"></i>{{ __('Proceed to payment ') }}</button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection
@push('js')
<script>
    "use strict";

    // Get all add-gateway-item elements
    const addGatewayItems = document.querySelectorAll('.add-gateway-item');

    // Add click event listener to each add-gateway-item
    addGatewayItems.forEach(function (item) {
        item.addEventListener('click', function () {
            // Remove 'active' class from all add-gateway-items
            addGatewayItems.forEach(function (item) {
                item.classList.remove('active');
            });
            // Add 'active' class to the clicked add-gateway-item
            this.classList.add('active');
        });
    });

    var globalData;
    var currency = @json($currency)

    $('input[name=gateway_code]').on('change', function (e) {
        $('.manual-row').empty();
        var code = $(this).val()
        var url = '{{ route("user.deposit.gateway",":code") }}';
        url = url.replace(':code', code);
        $.get(url, function (data) {

            globalData = data;

            if (data.currency === currency) {
                $('.conversion').addClass('d-none');
            } else {
                $('.conversion').removeClass('d-none');
            }

            $('.charge').text('Charge ' + data.charge + ' ' + (data.charge_type === 'percentage' ?
                ' % ' : currency))
            $('.conversion-rate').text('1' + ' ' + currency + ' = ' + data.rate + ' ' + data.currency)

            $('.method').html('<span class="type site-badge badge-primary">' + data.name + '</span>')
            $('.min-max').text('Minimum ' + data.minimum_deposit + ' ' + currency + ' and ' +
                'Maximum ' + data.maximum_deposit + ' ' + currency)
            $('#logo').html(`<img class="table-icon" src='${data.gateway_logo}'>`);
            var amount = $('#amount').val()

            if (Number(amount) > 0) {
                $('.amount').text((Number(amount)) +' '+ currency)
                var charge = data.charge_type === 'percentage' ? calPercentage(amount, data.charge) :
                    data.charge
                $('.charge2').text(charge + ' ' + currency)
                $('.total').text((Number(amount) + Number(charge)) + ' ' + currency)
            }

            if (data.credentials !== undefined) {
                $('.manual-row').append(data.credentials)
                imagePreview()
            }

        });

        $('#amount').on('keyup', function (e) {
            "use strict"
            var amount = $(this).val()
            $('.amount').text((Number(amount)) +' '+ currency);

            var charge = globalData.charge_type === 'percentage' ? calPercentage(amount, globalData
                .charge) : globalData.charge
            $('.charge2').text(charge + ' ' + currency)

            var total = (Number(amount) + Number(charge));

            $('.total').text(total + ' ' + currency)
            var payTotal = total * globalData.rate + ' ' + globalData.currency;
            $('.pay-amount').text(payTotal)
        })


    });
</script>
@endpush
