@use(App\Enums\TxnStatus)

@extends('frontend::layouts.user')

@section('title', __('My Earnings'))

@push('style')
<link rel="stylesheet" href="{{ asset('frontend/default/css/daterangepicker.css') }}">
@endpush

@section('content')
<div class="my-ads-area">
    @include('frontend::user.ads.include.__step')
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="my-ads-card">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('My Earnings') }}</h3>
                    </div>
                    <div class="transc-fields">
                        <form method="GET">
                            <div class="transactions-filed-wrapper">
                                <div class="input-field">
                                    <input type="text" name="daterange" value="{{ request('daterange') }}" autocomplete="off">
                                </div>
                                <button class="site-btn primary-btn" type="submit">
                                    <i class="icon-search-normal"></i>
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="site-custom-table-wrapper overflow-x-auto">
                        <div class="site-custom-table">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Description') }}</div>
                                    <div class="site-table-col">{{ __('Amount') }}</div>
                                    <div class="site-table-col">{{ __('Status') }}</div>
                                    <div class="site-table-col text-start">{{ __('Processing Timeline') }}</div>
                                </div>
                                @foreach ($histories as $history)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="description">
                                            <div class="event-icon">
                                                <i class="icon-monitor"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title">
                                                    {{ __('Ads Viewed - ').$history->ads?->title }}
                                                </div>
                                                <div class="date">{{ $history->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold green-color">
                                            {{ $currencySymbol.number_format($history->amount, 2) }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($history->is_claimed)
                                        <div class="type site-badge badge-success">{{ __('Success') }}</div>
                                        @else
                                        <div class="type site-badge badge-failed">{{ __('Processing') }}</div>
                                        @endif
                                    </div>
                                    <div class="site-table-col">
                                        <div class="fw-bold">
                                            @if(!$history->is_claimed)
                                                @php
                                                    $percentage = $history->calculateClaimPercentage();
                                                @endphp
                                                <div class="progress-advertisement-item w-auto" data-total-duration="{{ $history->claimable_at->diffInSeconds($history->created_at) }}" data-time-passed="{{ now()->diffInSeconds($history->created_at) }}">
                                                    <div class="progress-count-inner">
                                                        <span class="progress-count">{{ $percentage }}%</span>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" data-width="{{ $percentage }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="type site-badge badge-success">{{ __('Claimed') }}</div>
                                            @endif
                                        </div>
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

    // For each bonus progress element
    $('.progress-advertisement-item').each(function () {
        let $this = $(this);
        let totalDuration = $this.data('total-duration');
        let timePassed = $this.data('time-passed');

        let progressPercentage = (timePassed / totalDuration) * 100;

        // Update the progress every second
        let interval = setInterval(function () {
            if (progressPercentage < 100) {
                timePassed += 1;
                progressPercentage = (timePassed / totalDuration) * 100;
                $this.find('.progress-bar').css('width', progressPercentage + '%');
                $this.find('.progress-count').text(progressPercentage.toFixed(2) + '%');
            } else {
                clearInterval(interval);
            }
        }, 1000);
    });

</script>
@endpush
