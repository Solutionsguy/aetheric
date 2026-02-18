@extends('frontend::layouts.auth')
@section('title')
{{ __('Verify Email') }}
@endsection
@section('content')
<!-- verification area start -->
<section class="verification-area">
    <div class="auth-wrapper">
        <div class="contents-inner">
            <div class="content">
                @if(setting('email_verification'))
                <div class="account-steps justify-content-center">
                    <div class="single-step">
                        <span class="line"></span>
                        <p class="description">{{ __('Create account') }}</p>
                    </div>
                    <div class="single-step active">
                        <span class="line"></span>
                        <p class="description">{{ __('Verification') }}</p>
                    </div>
                </div>
                @endif
                <div class="top-content">
                    <h3 class="title">{{ __('Verify Your Email') }}</h3>
                    <p class="description">
                        {{ __('Sent the link on your email. Please check your inbox') }}
                    </p>
                    @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success">
                        <p>{{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </p>
                    </div>
                    @endif
                </div>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <div class="inputs">
                        <button type="submit" class="site-btn primary-btn w-100">{{ __('Resend Link') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- verification area end -->
@endsection
