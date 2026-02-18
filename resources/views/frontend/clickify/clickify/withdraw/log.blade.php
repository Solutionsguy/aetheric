@extends('frontend::layouts.user')
@section('title')
    {{ __('Withdraw History') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('frontend/default/css/daterangepicker.css') }}">
@endpush
@section('content')
<div class="fund-transfer-history-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="fund-transfer-history">
                    <div class="site-card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                            <h3 class="site-card-title mb-0">{{ __('Withdraw History') }}</h3>
                            <a href="{{ route('user.withdraw.view') }}" class="site-btn primary-btn"><i class="icon-repeat-circle"></i>{{ __('Withdraw') }}</a>
                        </div>
                    </div>
                    <div class="fund-transfer-inner">
                        <div class="my-ads-fields">
                            <form action="" method="GET">
                                <div class="fund-transfer-history-field">
                                    <div class="input-field">
                                        <input type="text" class="box-input" name="trx" value="{{ request('trx') }}" placeholder="{{ __('Transaction ID') }}">
                                    </div>
                                    <div class="input-field">
                                        <input type="text" name="daterange" id="daterange" value="{{ request('daterange') }}" autocomplete="off">
                                    </div>
                                    <button class="site-btn primary-btn" type="submit"><i class="icon-search-normal"></i>{{ __('Search') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="site-custom-table-wrapper overflow-x-auto">
                            <div class="site-custom-table">
                                <div class="contents">
                                    <div class="site-table-list site-table-head">
                                        <div class="site-table-col">{{ __('Description') }}</div>
                                        <div class="site-table-col">{{ __('Transaction ID') }}</div>
                                        <div class="site-table-col">{{ __('Amount') }}</div>
                                        <div class="site-table-col">{{ __('Charge') }}</div>
                                        <div class="site-table-col">{{ __('Status') }}</div>
                                        <div class="site-table-col"> {{ __('Gateway') }} </div>
                                    </div>
                                    @foreach ($withdraws as $history)
                                    <div class="site-table-list">
                                        <div class="site-table-col">
                                            <div class="found-history-description">
                                                <div class="icon">
                                                    <i class="icon-money-send"></i>
                                                </div>
                                                <div class="content">
                                                    <h3 class="title">{{ $history->description }}</h3>
                                                    <p class="date">{{ $history->created_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="site-table-col">
                                            <span class="text fw-semibold black-color">{{ $history->tnx }}</span>
                                        </div>
                                        <div class="site-table-col">
                                            <span class="text green-color fw-semibold">-{{ $currencySymbol.$history->amount }}</span>
                                        </div>
                                        <div class="site-table-col">
                                            <span class="text fw-semibold red-color">-{{ $currencySymbol.$history->charge }}</span>
                                        </div>
                                        <div class="site-table-col">
                                            <span @class([
                                                'site-badge',
                                                'badge-pending' => $history->status->value == 'pending',
                                                'badge-success' => $history->status->value == 'success',
                                                'badge-failed' => $history->status->value == 'failed',
                                            ])>
                                                {{ ucfirst($history->status->value) }}
                                            </span>
                                        </div>
                                        <div class="site-table-col">
                                            {{ $history->method }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{ $withdraws->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script src="{{ asset('frontend/default/js/moment.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/daterangepicker.min.js') }}"></script>
<script>
    "use strict";
    
    // Initialize datepicker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    });

    // Reset filter
    $('.reset-filter').on('click',function(){
        window.location.href = "{{ route('user.withdraw.log') }}";
    });


    @if(request('daterange') == null)
    // Set default is empty for date range
    $('input[name=daterange]').val('');
    @endif

</script>
@endpush
@endsection
