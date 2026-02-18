@extends('frontend::layouts.auth')

@section('title')
    {{ __('Login') }}
@endsection
@section('content')
    <!-- Sign area start -->
    <section class="sign-area">
        <div class="auth-wrapper">
            <div class="contents-inner">
                <div class="content">
                    <div class="top-content">
                        <h3 class="title">{{ $data['title'] }}</h3>
                    </div>
                    <div class="auth-form-wrapper">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="list-unstyled">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="single-input has-left-icon">
                                <label class="input-label" for="">{{ __('Email Address') }}<span
                                        class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="email" name="email" class="box-input email-input" required
                                        value="{{ old('email') }}">
                                    <span class="icon">
                                        <i class="icon-sms"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="single-input has-right-icon has-left-icon">
                                <label class="input-label" for="">{{ __('Password') }}<span
                                        class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="password" name="password" class="box-input password-input" required>
                                    <div class="password">
                                        <img src="{{ asset('frontend/default/images/icons/eye-off.svg') }}"
                                            class="password-hide-show eyeicon" alt="">
                                    </div>
                                    <span class="icon">
                                        <i class="icon-lock"></i>
                                    </span>
                                </div>
                            </div>
                            @if ($googleReCaptcha)
                                <div class="g-recaptcha mb-3" id="feedback-recaptcha"
                                    data-sitekey="{{ json_decode($googleReCaptcha->data, true)['site_key'] }}">
                                </div>
                            @endif
                            <div class="remember-content">
                                <div class="custom-checkbox">
                                    <input class="inp-cbx" id="check-sign-in" type="checkbox" name="remember_me"
                                        style="display: none;" />
                                    <label class="cbx" for="check-sign-in">
                                        <span>
                                            <svg width="12px" height="9px" viewbox="0 0 12 9">
                                                <polyline points="1 5 4 8 11 1"></polyline>
                                            </svg>
                                        </span>
                                        <span>{{ __('Keep signed in') }}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="inputs">
                                <button type="submit" class="site-btn primary-btn w-100">{{ __('Sign in') }}</button>
                            </div>
                            <div class="bottom-content">
                                <div class="have-acount">
                                    <p>{{ __('Don\'t have an account?') }} <a
                                            href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
                                </div>
                                <div class="forgot">
                                    <a href="{{ route('password.request') }}">{{ __('Forgot Password') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sign area end -->
@endsection
@section('script')
    @if ($googleReCaptcha)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        (function($) {
            'use strict';

            // password hide show
            let eyeicon = document.getElementById('eyeicon')
            let passo = document.getElementById('passo')
            eyeicon.onclick = function() {
                if (passo.type === "password") {
                    passo.type = "text";
                    eyeicon.src = '{{ asset('frontend/default/images/icons/eye.svg') }}'
                } else {
                    passo.type = "password";
                    eyeicon.src = '{{ asset('frontend/default/images/icons/eye-off.svg') }}'
                }
            }

        })(jQuery);
    </script>
@endsection
