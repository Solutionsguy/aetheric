@extends('frontend::layouts.user')
@section('title')
{{ __('Dashboard') }}
@endsection
@section('content')
<div class="row gy-30">
    <div class="col-xxl-12">
        
        @include('frontend::user.include.__kyc_info')

        <div class="dashboard-card">
            <div class="user-profile">
                <span class="info-title">{{ __('Balance') }}</span>
                <h3 class="number">{{ $currencySymbol.auth()->user()->balance }}</h3>
                <div class="icon">
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.8398 17.9123C10.8398 19.5248 12.0773 20.8248 13.6148 20.8248H16.7523C18.0898 20.8248 19.1773 19.6873 19.1773 18.2873C19.1773 16.7623 18.5148 16.2248 17.5273 15.8748L12.4898 14.1248C11.5023 13.7748 10.8398 13.2373 10.8398 11.7123C10.8398 10.3123 11.9273 9.1748 13.2648 9.1748H16.4023C17.9398 9.1748 19.1773 10.4748 19.1773 12.0873"
                                stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 7.5V22.5" stroke="white" stroke-width="2.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="white" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Viewed Ads') }}</span>
                <h3 class="number">{{ $user->adsHistories?->count() }}</h3>
                <p class="description">{{ __('Total ads you have viewed') }}</p>
                <div class="btn-inner">
                    <a class="round-btn" href="{{ route('user.my.earnings') }}"><span><i class="fa-sharp fa-regular fa-arrow-up-long"></i></span></a>
                </div>
                <div class="icon">
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M22.5 23.575H21.55C20.55 23.575 19.6 23.9625 18.9 24.6625L16.7625 26.775C15.7875 27.7375 14.2 27.7375 13.225 26.775L11.0875 24.6625C10.3875 23.9625 9.425 23.575 8.4375 23.575H7.5C5.425 23.575 3.75 21.9125 3.75 19.8625V6.2125C3.75 4.1625 5.425 2.5 7.5 2.5H22.5C24.575 2.5 26.25 4.1625 26.25 6.2125V19.85C26.25 21.9 24.575 23.575 22.5 23.575Z"
                                stroke="#02BAD8" stroke-width="2.25" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M15.0883 11.1875C15.0383 11.1875 14.9633 11.1875 14.9008 11.1875C13.5883 11.1375 12.5508 10.075 12.5508 8.75C12.5508 7.4 13.6383 6.3125 14.9883 6.3125C16.3383 6.3125 17.4258 7.4125 17.4258 8.75C17.4383 10.075 16.4008 11.15 15.0883 11.1875Z"
                                stroke="#02BAD8" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M11.5633 14.95C9.90078 16.0625 9.90078 17.875 11.5633 18.9875C13.4508 20.25 16.5508 20.25 18.4383 18.9875C20.1008 17.875 20.1008 16.0625 18.4383 14.95C16.5508 13.7 13.4633 13.7 11.5633 14.95Z"
                                stroke="#02BAD8" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Transactions') }}</span>
                <h3 class="number">{{ $total_transaction }}</h3>
                <p class="description">{{ __('Total number of transactions') }}</p>
                <div class="btn-inner">
                    <a class="round-btn" href="{{ route('user.transactions') }}"><span><i class="fa-sharp fa-regular fa-arrow-up-long"></i></span></a>
                </div>
                <div class="icon">
                    <span>
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.5 12.85V14C26.4985 16.6955 25.6256 19.3184 24.0117 21.4773C22.3977 23.6362 20.1291 25.2156 17.5442 25.9799C14.9593 26.7442 12.1966 26.6524 9.66809 25.7182C7.1396 24.7841 4.98082 23.0576 3.5137 20.7963C2.04658 18.5351 1.34974 15.8601 1.5271 13.1704C1.70445 10.4807 2.74651 7.92042 4.49785 5.87135C6.24919 3.82229 8.61598 2.39424 11.2452 1.8002C13.8745 1.20615 16.6253 1.47793 19.0875 2.57501"
                                stroke="#29B475" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M26.5 4L14 16.5125L10.25 12.7625" stroke="#29B475" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Deposit') }}</span>
                <h3 class="number">{{ $currencySymbol.$user->deposit_balance }}</h3>
                <p class="description">{{ __('Available deposit balance') }}</p>
                <div class="btn-inner">
                    <a class="round-btn" href="{{ route('user.transactions') }}"><span><i class="fa-sharp fa-regular fa-arrow-up-long"></i></span></a>
                </div>
                <div class="icon">
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.875 17.1875C11.875 18.4 12.8125 19.375 13.9625 19.375H16.3125C17.3125 19.375 18.125 18.525 18.125 17.4625C18.125 16.325 17.625 15.9125 16.8875 15.65L13.125 14.3375C12.3875 14.075 11.8875 13.675 11.8875 12.525C11.8875 11.475 12.7 10.6125 13.7 10.6125H16.05C17.2 10.6125 18.1375 11.5875 18.1375 12.8"
                                stroke="#F23450" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 9.375V20.625" stroke="#F23450" stroke-width="1.875" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M27.5 15C27.5 21.9 21.9 27.5 15 27.5C8.1 27.5 2.5 21.9 2.5 15C2.5 8.1 8.1 2.5 15 2.5"
                                stroke="#F23450" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M21.25 3.75V8.75H26.25" stroke="#F23450" stroke-width="1.875"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M27.5 2.5L21.25 8.75" stroke="#F23450" stroke-width="1.875" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Earnings') }}</span>
                <h3 class="number">{{ $currencySymbol.$total_earnings }}</h3>
                <p class="description">{{ __('Total amount earned') }}</p>
                
                <div class="icon">
                    <span>
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.83984 16.9123C9.83984 18.5248 11.0773 19.8248 12.6148 19.8248H15.7523C17.0898 19.8248 18.1773 18.6873 18.1773 17.2873C18.1773 15.7623 17.5148 15.2248 16.5273 14.8748L11.4898 13.1248C10.5023 12.7748 9.83984 12.2373 9.83984 10.7123C9.83984 9.3123 10.9273 8.1748 12.2648 8.1748H15.4023C16.9398 8.1748 18.1773 9.4748 18.1773 11.0873"
                                stroke="#6596F4" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M14 6.5V21.5" stroke="#6596F4" stroke-width="2.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M17.75 26.5H10.25C4 26.5 1.5 24 1.5 17.75V10.25C1.5 4 4 1.5 10.25 1.5H17.75C24 1.5 26.5 4 26.5 10.25V17.75C26.5 24 24 26.5 17.75 26.5Z"
                                stroke="#6596F4" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Referral') }}</span>
                <h3 class="number">{{ $total_referral }}</h3>
                <p class="description">{{ __('Total number of referrals') }}</p>
                <div class="btn-inner">
                    <a class="round-btn" href="{{ route('user.referral') }}"><span><i class="fa-sharp fa-regular fa-arrow-up-long"></i></span></a>
                </div>
                <div class="icon">
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.4512 13.5875C11.3262 13.575 11.1762 13.575 11.0387 13.5875C8.06367 13.4875 5.70117 11.05 5.70117 8.05C5.70117 4.9875 8.17617 2.5 11.2512 2.5C14.3137 2.5 16.8012 4.9875 16.8012 8.05C16.7887 11.05 14.4262 13.4875 11.4512 13.5875Z"
                                stroke="#800AF6" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M20.5121 5C22.9371 5 24.8871 6.9625 24.8871 9.375C24.8871 11.7375 23.0121 13.6625 20.6746 13.75C20.5746 13.7375 20.4621 13.7375 20.3496 13.75"
                                stroke="#800AF6" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M5.20039 18.2C2.17539 20.225 2.17539 23.525 5.20039 25.5375C8.63789 27.8375 14.2754 27.8375 17.7129 25.5375C20.7379 23.5125 20.7379 20.2125 17.7129 18.2C14.2879 15.9125 8.65039 15.9125 5.20039 18.2Z"
                                stroke="#800AF6" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M22.9258 25C23.8258 24.8125 24.6758 24.45 25.3758 23.9125C27.3258 22.45 27.3258 20.0375 25.3758 18.575C24.6883 18.05 23.8508 17.7 22.9633 17.5"
                                stroke="#800AF6" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Withdraw') }}</span>
                <h3 class="number">{{ $currencySymbol.$total_withdraws }}</h3>
                <p class="description">{{ __('Total withdrawal amount') }}</p>
                <div class="btn-inner">
                    <a class="round-btn" href="{{ route('user.transactions') }}"><span><i class="fa-sharp fa-regular fa-arrow-up-long"></i></span></a>
                </div>
                <div class="icon">
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.875 17.1875C11.875 18.4 12.8125 19.375 13.9625 19.375H16.3125C17.3125 19.375 18.125 18.525 18.125 17.4625C18.125 16.325 17.625 15.9125 16.8875 15.65L13.125 14.3375C12.3875 14.075 11.8875 13.675 11.8875 12.525C11.8875 11.475 12.7 10.6125 13.7 10.6125H16.05C17.2 10.6125 18.1375 11.5875 18.1375 12.8"
                                stroke="#FFAC3E" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 9.375V20.625" stroke="#FFAC3E" stroke-width="2.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M27.5 15C27.5 21.9 21.9 27.5 15 27.5C8.1 27.5 2.5 21.9 2.5 15C2.5 8.1 8.1 2.5 15 2.5"
                                stroke="#FFAC3E" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M27.5 7.5V2.5H22.5" stroke="#FFAC3E" stroke-width="2.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M21.25 8.75L27.5 2.5" stroke="#FFAC3E" stroke-width="2.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="single-card">
                <span class="info-title">{{ __('Support Tickets') }}</span>
                <h3 class="number">{{ $total_tickets }}</h3>
                <p class="description">{{ __('Number of tickets you’ve submitted') }}</p>
                <div class="btn-inner">
                    <a class="round-btn" href="{{ route('user.ticket.index') }}"><span><i class="fa-sharp fa-regular fa-arrow-up-long"></i></span></a>
                </div>
                <div class="icon">
                    <span>
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 27.5C21.9036 27.5 27.5 21.9036 27.5 15C27.5 8.09644 21.9036 2.5 15 2.5C8.09644 2.5 2.5 8.09644 2.5 15C2.5 21.9036 8.09644 27.5 15 27.5Z"
                                stroke="#10E264" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M11.3633 11.25C11.6572 10.4146 12.2372 9.71011 13.0007 9.2614C13.7642 8.81268 14.6619 8.64865 15.5348 8.79837C16.4076 8.94809 17.1993 9.40188 17.7696 10.0794C18.34 10.7569 18.6521 11.6144 18.6508 12.5C18.6508 15 14.9008 16.25 14.9008 16.25"
                                stroke="#10E264" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 21.25H15.0125" stroke="#10E264" stroke-width="2.25" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-12">
        <div class="recent-transactions-wrapper">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="site-card-title">{{ __('Recent Transactions') }}</div>
                </div>
                <div class="site-card-body p-0 overflow-x-auto">
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
    </div>
</div>
@include('frontend::user.include.__signup_bonus')
@endsection
