<?php
$newsletter = \App\Models\LandingPage::where('code', 'newsletter')
    ->where('locale', app()->getLocale())
    ->first();

$newsletterData = $newsletter ? json_decode($newsletter->data, true) : null;
?>

<section class="newsletter-section section-space">
    <div class="container">
        @if($newsletterData && isset($newsletterData['img'], $newsletterData['title_big'], $newsletterData['title_small']))
            <div class="newsletter-main include-bg" data-background="{{ asset($newsletterData['img']) }}">
                <div class="newsletter-grid">
                    <div class="content">
                        <p class="description">{{ $newsletterData['title_big'] }}</p>
                        <h3 class="title">{{ $newsletterData['title_small'] }}</h3>
                    </div>
                    <div class="newsletter-input-form">
                        <form action="{{ route('subscriber') }}" method="POST">
                            @csrf
                            <input type="text" name="email" placeholder="{{__('Enter your email')}}">
                            <button class="site-btn primary-btn" type="submit">{{__('Submit')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <p>{{ __('Newsletter data is not available.') }}</p>
        @endif
    </div>
</section>