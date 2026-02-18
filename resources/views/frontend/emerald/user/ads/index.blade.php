@use(App\Enums\AdsType)
@extends('frontend::layouts.user')
@section('title')
{{ __('All Ads') }}
@endsection
@section('content')
<div class="ads-area">
    @include('frontend::user.ads.include.__step')
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <h3 class="site-card-title">@yield('title')</h3>
                        <form method="get" id="filter">
                            <div class="input-select entries w-100">
                                <select name="type" onchange="$('#filter').submit()">
                                    <option value="">{{ __('All Ads') }}</option>
                                    <option value="link" @selected(request('type') == 'link')>{{ __('Link/URL') }}</option>
                                    <option value="image" @selected(request('type') == 'image')>{{ __('Banner/Image') }}</option>
                                    <option value="script" @selected(request('type') == 'script')>{{ __('Script/Code') }}</option>
                                    <option value="youtube" @selected(request('type') == 'youtube')>{{ __('YouTube') }}</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ads-item-inner">
                    <div class="row">
                        <div class="ads-item-grid">
                            @foreach ($ads as $ad)
                            <div @class([
                                'ads-single-item',
                                'disabled' => $ad->last_viewed_at !== null
                            ]) data-id="{{ $ad->id }}" data-remaining-time="{{ $ad->last_viewed_at?->timestamp  }}">
                                <div class="content-inner">
                                    <div class="contents">
                                        <h3 class="title">{{ $ad->title }}</h3>
                                        <span class="rounded-pill badge">
                                            {{ $ad->type_value }}
                                        </span>
                                        <p class="remaining-countdown-{{ $ad->id }}">{{ __('Ads Available') }} : <span id="ads-countdown-{{ $ad->id }}" class="ads-countdown">{{ __('Counting') }}</span></p>
                                        <p class="description">{{ __('Duration: :seconds Seconds',['seconds' => $ad->duration]) }}</p>
                                        <h4 class="currency">{{ $currencySymbol.$ad->amount }}</h4>
                                    </div>
                                    <div class="btn-wrap">
                                        <a @class([
                                            'site-btn',
                                            'disabled' => $ad->last_viewed_at !== null
                                        ]) target="_blank" href="{{ route('user.ads.view',encrypt($ad->id)) }}"><i class="icon-eye"></i> {{ __('View Ads') }}</a>
                                    </div>
                                </div>
                                <div class="bg-pattern">
                                    <img src="{{ $ad->type_bg }}" alt="{{ $ad->title }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if(count($ads) == 0)
                            @include('frontend::user.include.__no_data_found')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        $('.ads-single-item').each(function () {
            let adId = $(this).data('id');
            let lastViewedAt = parseInt($(this).data('remaining-time'));
            let currentTime = new Date().getTime(); // Get current time in milliseconds

            // 24 hours in milliseconds
            let countdownTime = 24 * 60 * 60 * 1000;

            // Ensure lastViewedAt is valid
            if (!isNaN(lastViewedAt) && lastViewedAt > 0) {
                let timeDifference = currentTime - (lastViewedAt * 1000); // Convert seconds to milliseconds
                let timeRemaining = countdownTime - timeDifference;

                if (timeRemaining > 0) {
                    startCountdown(timeRemaining);
                } else {
                    $('.remaining-countdown-' + adId).hide();
                }
            } else {
                $('.remaining-countdown-' + adId).hide();
            }

            function startCountdown(timeRemaining) {
                let countdownInterval = setInterval(function() {
                    timeRemaining -= 1000;

                    let hours = Math.floor((timeRemaining / (1000 * 60 * 60)) % 24);
                    let minutes = Math.floor((timeRemaining / (1000 * 60)) % 60);
                    let seconds = Math.floor((timeRemaining / 1000) % 60);

                    let formattedTime = `${hours}H ${minutes}M ${seconds}S`;
                    $('#ads-countdown-' + adId).text(formattedTime);

                    if (timeRemaining <= 0) {
                        clearInterval(countdownInterval);
                        $('.remaining-countdown-' + adId).hide();
                    }
                }, 1000);
            }
        });
    });
</script>
@endpush
