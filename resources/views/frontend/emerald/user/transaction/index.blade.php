@php use App\Enums\TxnStatus; @endphp
@extends('frontend::layouts.user')
@section('title')
{{ __('Transactions') }}
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
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('Transactions') }}</h3>
                    </div>
                    <div class="transc-fields">
                        <form method="GET">
                            <div class="transactions-filed-wrapper">
                                <div class="input-field">
                                    <input type="text" name="trx" class="box-input" value="{{ request('trx') }}" placeholder="{{ __('Transaction ID') }}">
                                </div>
                                <div class="input-select">
                                    <select name="type">
                                        <option value="all" @selected(request('type')=='all' )>{{ __('All Type') }}</option>
                                        <option value="deposit" @selected(request('type')=='deposit' )>{{ __('Deposit') }}</option>
                                        <option value="ads_viewed" @selected(request('type')=='ads_viewed' )>{{ __('Ads Viewed') }}</option>
                                        <option value="ads_posted" @selected(request('type')=='ads_posted' )>{{ __('Ads Posted') }}</option>
                                        <option value="received_money" @selected(request('type')=='received_money' )>{{ __('Received Money') }}</option>
                                        <option value="refund" @selected(request('type')=='refund' )>{{ __('Refunded') }}</option>
                                        <option value="plan_purchased" @selected(request('type')=='plan_purchased' )>{{ __('Plan Purchased') }}</option>
                                        <option value="fund_transfer" @selected(request('type')=='fund_transfer' )>{{ __('Fund Transfer') }}</option>
                                        <option value="withdraw" @selected(request('type') == 'withdraw' )>{{ __('Withdraw') }}</option>
                                        <option value="referral" @selected(request('type')=='referral' )> {{ __('Referral') }}</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <input type="text" name="daterange" value="{{ request('daterange') }}" autocomplete="off">
                                </div>

                                <button class="site-btn primary-btn" type="submit">
                                    <i class="icon-search-normal"></i>
                                    {{ __('Search') }}
                                </button>

                                <div class="input-select entries">
                                    <select name="limit" onchange="$('form').submit()">
                                        <option value="15" @selected(request('limit',15)=='15' )>15</option>
                                        <option value="30" @selected(request('limit')=='30' )>30</option>
                                        <option value="50" @selected(request('limit')=='50' )>50</option>
                                        <option value="100" @selected(request('limit')=='100' )>100</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="site-custom-table-wrapper overflow-x-auto">
                        <div class="site-custom-table">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Description') }}</div>
                                    <div class="site-table-col">{{ __('Transactions ID') }}</div>
                                    <div class="site-table-col">{{ __('Type') }}</div>
                                    <div class="site-table-col">{{ __('Amount') }}</div>
                                    <div class="site-table-col">{{ __('Charge') }}</div>
                                    <div class="site-table-col">{{ __('Status') }}</div>
                                    <div class="site-table-col">{{ __('Method') }}</div>
                                </div>
                                @foreach ($transactions as $transaction)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="event-icon">
                                                {!! getTransactionIcon($transaction->type) !!}
                                            </div>
                                            <div class="content">
                                                <div class="title">
                                                    {{ $transaction->description }}
                                                    @if(!in_array($transaction->approval_cause,['none',""]))
                                                    <button type="button" class="message-icon" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $transaction->approval_cause }}">
                                                        <i class="icon-messages-3"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="date">{{ $transaction->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">{{ $transaction->tnx }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="type site-badge badge-primary">
                                            {{ ucfirst(str_replace('_',' ',$transaction->type->value)) }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        <div @class([ "fw-bold" , "green-color"=> isPlusTransaction($transaction->type) == true,
                                            "red-color" => isPlusTransaction($transaction->type) == false
                                            ])>{{ isPlusTransaction($transaction->type) == true ? '+' : '-' }}{{ number_format($transaction->amount,2).' '.$currency }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold red-color">-{{ $transaction->charge.' '.$currency }}</div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($transaction->status->value == 'failed')
                                        <div class="type site-badge badge-failed">{{ $transaction->status->value }}</div>
                                        @elseif($transaction->status->value == 'success')
                                        <div class="type site-badge badge-success">{{ $transaction->status->value }}</div>
                                        @elseif($transaction->status->value == 'pending')
                                        <div class="type site-badge badge-pending">{{ $transaction->status->value }}</div>
                                        @endif
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            {{ $transaction->method !== '' ? ucfirst(str_replace('-',' ',$transaction->method)) :  __('System') }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($transactions) == 0)
                                @include('frontend::user.include.__no_data_found')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ asset('frontend/default/js/moment.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/daterangepicker.min.js') }}"></script>
<script>
    // Initialize datepicker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    });

    @if(request('daterange') == null)
    // Set default is empty for date range
    $('input[name=daterange]').val('');
    @endif
</script>
@endpush