
@extends('frontend::layouts.user')
@section('title')
{{ __('Subsciption Preview') }}
@endsection
@section('content')
<div class="add-found-area">
    <form action="{{ route('user.subscription.now') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
    <div class="row gy-30">
        <div class="col-xxl-6 col-xl-6">
            <div class="add-fund-box">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('Subsciption Preview') }}</h3> 
                    </div>
                    <div class="add-found-wrapper">
                        <div class="add-gateway">
                            <div class="select-gateway">
                                <h6>{{ __('Select Purchase Method') }}</h6>
                                <label class="label-radio" for="balanceRadio">
                                    <input type="radio" name="method" id="balanceRadio" value="balance">
                                    <span>{{ __('My Balance') }}</span>
                                </label>
                                <label class="label-radio" for="gatewayRadio">
                                    <input type="radio" name="method" id="gatewayRadio" value="gateway">
                                    <span>{{ __('Direct Gateway') }}</span>
                                </label>
                                <div id="balanceContent" class="select-gateway-item">
                                    <p class="description">{{ __('Your balance is') }} <span>{{ $currencySymbol.auth()->user()->balance }}</span></p>
                                </div>
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
                            <form action="#">
                                <div class="manual-row">

                                </div>
                            </form>
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
                            <h6 class="mb-2">{{ __('Plan Details') }}</h6>
                            <hr class="mb-4">
                            <ul class="mb-3">
                                <li>
                                    <span class="info">{{ __('Daily Limit') }} :</span>
                                    <span class="info">{{ $plan->daily_limit }} {{ __('Ads') }}</span>
                                </li>

                                <li>
                                    <span class="info">{{ __('Validity') }} :</span>
                                    <span class="info">{{ $plan->validity }} {{ __('Days') }}</span>
                                </li>

                                <li>
                                    <span class="info">{{ __('Withdraw Limit') }} :</span>
                                    <span class="info">{{ $plan->withdraw_limit == 0 ? __('Unlimited') : $currencySymbol.$plan->withdraw_limit }}</span>
                                </li>

                                <li>
                                    <span class="info">{{ __('Referral Bonus') }} :</span>
                                    <span class="info">{{ __('Upto :level Level',['level' => $plan->referral_level ]) }}</span>
                                </li>

                                <li>
                                    <span class="info">{{ __('Price') }} :</span>
                                    <span class="info">{{ $plan->price.' '.$currency }}</span>
                                </li>
                            </ul>

                            <div class="payment-details d-none">
                                <h6 class="mb-2">{{ __('Gateway Details') }}</h6>
                                <hr class="mb-4">
                                <ul>
                                    <li>
                                        <span class="info">{{ __('Payment Method') }}:</span>
                                        <span class="info method"></span>
                                    </li>

                                    <li>
                                        <span class="info">{{ __('Gateway Logo') }} :</span>
                                        <span class="balance-thumb">
                                            <img src="" id="gateway_logo">
                                        </span>
                                    </li>
    
                                    <li>
                                        <span class="info">{{ __('Amount') }} :</span>
                                        <span class="info">{{ $plan->price.' '.$currency }}</span>
                                        <input type="hidden" id="price" value="{{ $plan->price }}">
                                    </li>
    
                                    <li>
                                        <span class="info">{{ __('Charge') }} :</span>
                                        <span class="info text-danger"> <span id="charge"></span> {{ $currency }}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{ __('Payable Amount') }} :</span>
                                        <span class="info" id="payable-amount"></span>
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
                <button class="input-btn btn-primary" type="submit"><i class="icon-arrow-right-2"></i>{{ __('Submit') }}</button>
            </div>
        </div>
    </div>
    </form>
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

    document.addEventListener('DOMContentLoaded', function () {
      const balanceRadio = document.getElementById('balanceRadio');
      const gatewayRadio = document.getElementById('gatewayRadio');
      const balanceContent = document.getElementById('balanceContent');
      const gatewayContent = document.getElementById('gatewayContent');

      balanceRadio.addEventListener('change', function () {
        if (balanceRadio.checked) {
          balanceContent.style.display = 'block';
          gatewayContent.style.display = 'none';
        }
      });

      gatewayRadio.addEventListener('change', function () {
        if (gatewayRadio.checked) {
          gatewayContent.style.display = 'block';
          balanceContent.style.display = 'none';
        }
      });

      // Hide both contents initially
      balanceContent.style.display = 'none';
      gatewayContent.style.display = 'none';
    });

    $('input[name=method]').on('change',function(){
        const paymentDetails = $('.payment-details');
        if($('input[name=method]:checked').val() == 'balance'){
            paymentDetails.addClass('d-none');
            $('.manual-row').empty();
            $('.add-gateway-grid > label.active').removeClass('active');
            $('input[name=gateway_code]:checked').attr('checked',false);
            $('#charge').text('');
            $('#gateway_logo').attr('src','');
            $('#payable-amount').text('');
        }
    });

    $('.disable').on('click',function(){
        $('.manual-row > input,textarea,select').val('');
    })

    $('input[name=gateway_code]').on('change', function (e) {
        "use strict";
        e.preventDefault();

        $('.payment-details').removeClass('d-none');

        var code = $(this).val();
        var url = '{{ route("user.deposit.gateway",":code") }}';
        url = url.replace(':code', code);

        var price = $('#price').val();
        var charge = 0;

        $('.manual-row').empty();

        $.get(url, function (data) {
            charge = data.charge_type == 'fixed' ? data.charge : (data.charge / 100) * price;

            var total = (parseFloat(price) + parseFloat(charge))  * parseFloat(data.rate);
            $('#charge').text(charge);
            $('#gateway_logo').attr('src',data.gateway_logo);
            $('#payable-amount').text( parseFloat(total).toFixed(2) + ' ' + data.currency)
            $('.method').html('<span class="type site-badge badge-primary">' + data.name + '</span>')

            if (data.credentials !== undefined) {
                $('.manual-row').append(data.credentials)
            }
        });
    });

  </script>
@endpush