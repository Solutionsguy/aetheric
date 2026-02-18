@extends('frontend::layouts.user')
@section('title')
{{ __('Referral') }}
@endsection
@section('content')
<div class="referral-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="referral-banner include-bg"
                data-background="{{ asset('frontend/default/images/bg/referral-bg.png') }}">
                <div class="banner-content">
                    <h1 class="title">
                        {{ __('Earn :amount for every signed up each friend!',['amount' => $currencySymbol.setting('referral_bonus','fee') ]) }}
                    </h1>
                </div>
                <div class="referral-step-wrapper">
                    @if(is_array($rules) && setting('referral_rules_visibility'))
                    @foreach ($rules as $rule)
                    <div class="referral-step-item">
                        <div class="icon">
                            <span><i class="fas {{ $rule->icon }}"></i></span>
                        </div>
                        <div class="content">
                            <h3 class="title">{{ $rule->title }}</h3>
                            <p class="description">{{ $rule->description }}</p>
                        </div>
                        @if(!$loop->last)
                        <span class="step-arrow">
                            <svg width="217" height="49" viewBox="0 0 217 49" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.999999 36.1461C12.7412 19.3355 47.0926 -3.83622 94.295 29.8175C99.8933 33.8089 105.448 37.9857 111.801 40.6149C137.944 51.4343 182.005 56.5089 204 11"
                                    stroke="url(#paint0_linear_79_5675)" stroke-opacity="0.7" stroke-width="2"
                                    stroke-dasharray="4 4" />
                                <path
                                    d="M195.991 12.294L203.535 10.8364C204.426 10.6643 205.296 11.2524 205.468 12.1434L206.926 19.6878"
                                    stroke="#C6C2F9" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <defs>
                                    <linearGradient id="paint0_linear_79_5675" x1="204" y1="20.5" x2="-27" y2="29"
                                        gradientUnits="userSpaceOnUse">
                                        <stop stop-color="white">
                                            <stop offset="1" stop-color="#383AE5">
                                    </linearGradient>
                                </defs>
                            </svg>
                        </span>
                        @endif
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="referral-share-wrapper">
                <div class="referral-share-item">
                    <h3 class="title">{{ __('Share Your Referral Link') }}</h3>
                    <p class="description">
                        {{ __('You can also share your referral link by coping and sending it or sharing it o your social media') }}
                    </p>
                    <div class="input-field">
                        <input type="text" class="box-input" id="refLink" value="{{ $getReferral->link }}" readonly>
                    </div>
                    <div class="bottom-content">
                        <div class="btn-wrap">
                            <button class="site-btn primary-btn disable" id="copyLinkButton"><i
                                    class="icon-copy"></i>{{ __('Copy Link') }}</button>
                            <button class="site-btn primary-btn disable" id="shareLinkButton">
                                <span>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15 6.66663C16.3807 6.66663 17.5 5.54734 17.5 4.16663C17.5 2.78591 16.3807 1.66663 15 1.66663C13.6193 1.66663 12.5 2.78591 12.5 4.16663C12.5 5.54734 13.6193 6.66663 15 6.66663Z"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M5 12.5C6.38071 12.5 7.5 11.3807 7.5 10C7.5 8.61929 6.38071 7.5 5 7.5C3.61929 7.5 2.5 8.61929 2.5 10C2.5 11.3807 3.61929 12.5 5 12.5Z"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M15 18.3334C16.3807 18.3334 17.5 17.2141 17.5 15.8334C17.5 14.4527 16.3807 13.3334 15 13.3334C13.6193 13.3334 12.5 14.4527 12.5 15.8334C12.5 17.2141 13.6193 18.3334 15 18.3334Z"
                                            stroke="white" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M7.16016 11.2583L12.8518 14.575" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12.8435 5.42505L7.16016 8.74172" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                {{ __('Share') }}
                            </button>
                        </div>
                        <div class="client-meta">
                            <div class="content">
                                <p>{{ __(':people_count people join using this link',['people_count' => $getReferral->relationships()->count()]) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="referral-share-item">
                <h3 class="site-card-title ">{{ __('Referral Tree') }}</h3>
                <div class="main-referral-wrapper">
                    <div class="main-referral-tree">
                        @if($user->referrals->count() > 0)
                        <ul>
                            <li>
                                @include('frontend::referral.include.__tree',['levelUser' => $user,'level' => $level,'depth' => 1, 'me' => true])
                            </li>
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="site-card-title mb-0">{{ __('Referred Friends') }}</h3>
                </div>
                <div class="referral-table-wraper">
                    <div class="site-table referral-table table-responsive">
                        <table class="table">
                            <thead class="thead">
                                <tr>
                                    <th scope="col">{{ __('User') }}</th>
                                    <th scope="col">{{ __('Plan') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->referrals as $user)
                                <tr>
                                    <td>
                                        <div class="referral-user">
                                            <div class="thumb">
                                                <img src="{{ $user->avatar_path }}" alt="{{ $user->username }}">
                                            </div>
                                            <div class="content">
                                                <p class="description">{{ $user->username }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->plan?->name }}</td>
                                    <td>
                                        @if($user->status == 1)
                                        <div class="type site-badge badge-primary">{{ __('Active') }}</div>
                                        @elseif($user->status == 0)
                                        <div class="type site-badge badge-warning">{{ __('Deactivated') }}</div>
                                        @else
                                        <div class="type site-badge badge-danger">{{ __('Closed') }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // Copy link to clipboard
    const copyLinkButton = document.getElementById('copyLinkButton');
    const referralLinkInput = document.querySelector('#refLink');

    copyLinkButton.addEventListener('click', function () {
        const referralLink = referralLinkInput.value;

        // Copy the referral link to clipboard
        navigator.clipboard.writeText(referralLink)
            .then(() => {
                // Change button text to "Copied!"
                const originalText = copyLinkButton.innerHTML;
                copyLinkButton.innerHTML = '<i class="icon-copy"></i>Copied!';

                // Disable the button to prevent multiple clicks
                copyLinkButton.disabled = true;

                // Set a timeout to revert back to the original text after 2 seconds
                setTimeout(() => {
                    copyLinkButton.innerHTML = originalText;
                    copyLinkButton.disabled = false; // Re-enable the button
                }, 2000); // 2000ms = 2 seconds
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
            });
    });

    // Share referral link using Web Share API
    const shareLinkButton = document.getElementById('shareLinkButton');

    shareLinkButton.addEventListener('click', function () {
        const referralLink = referralLinkInput.value;

        if (navigator.share) {
            navigator.share({
                title: 'Referral Link',
                text: 'Join using my referral link!',
                url: referralLink,
            }).catch(console.error);
        } else {
            alert('Your browser does not support the Web Share API.');
        }
    });

</script>
@endpush
