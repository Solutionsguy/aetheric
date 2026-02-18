@extends('frontend::layouts.auth')

@section('title')
    {{ __('Register') }}
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/default/css/select2.min.css') }}">
@endpush

@section('content')
    <!-- Sign up area start -->
    <section class="sign-up-area">
        <div class="auth-wrapper">
            <div class="contents-inner">
                <div class="content">
                    @if(setting('email_verification'))
                    <div class="account-steps justify-content-center">
                        <div class="single-step active">
                            <span class="line"></span>
                            <p class="description">{{ __('Create account') }}</p>
                        </div>
                        <div class="single-step">
                            <span class="line"></span>
                            <p class="description">{{ __('Verification') }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="top-content">
                        <h3 class="title">{{ data_get($data,'title',__('Create an account')) }}</h3>
                    </div>
                    <div class="auth-form-wrapper">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.now') }}" method="POST">
                            @csrf
                            <div class="single-input has-left-icon">
                                <label class="input-label" for="">{{ __('First Name') }}<span class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="text" class="box-input name-input" name="first_name" value="{{ old('first_name') }}" required>
                                    <span class="icon">
                                        <i class="icon-profile-circle"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="single-input has-left-icon">
                                <label class="input-label" for="">{{ __('Last Name') }}<span class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="text" class="box-input name-input" name="last_name" value="{{ old('last_name') }}" required>
                                    <span class="icon">
                                        <i class="icon-profile-circle"></i>
                                    </span>
                                </div>
                            </div>
                            @if(getPageSetting('username_show'))
                                <div class="single-input has-left-icon">
                                    <label class="input-label" for="">{{ __('Username') }}@if(getPageSetting('username_validation')) <span class="text-danger">*</span> @endif</label>
                                    <div class="input-field">
                                        <input type="text" class="box-input name-input" name="username" value="{{ old('username') }}" required>
                                        <span class="icon">
                                        <i class="icon-profile-circle"></i>
                                    </span>
                                    </div>
                                </div>
                            @endif
                            <div class="single-input has-left-icon">
                                <label class="input-label" for="">{{ __('Email Address') }}<span class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="email" class="box-input email-input" name="email" value="{{ old('email') }}" required>
                                    <span class="icon">
                                    <i class="icon-sms"></i>
                                    </span>
                                </div>
                            </div>
                            @if(getPageSetting('country_show'))
                                <div class="single-input mb-3">
                                    <label class="input-label" for="">{{ __('Country') }} @if(getPageSetting('country_validation')) <span class="text-danger">*</span> @endif</label>
                                    <select name="country" class="box-input w-100" id="countrySelect">
                                        @foreach( getCountries() as $country)
                                            <option @selected($location->country_code == $country['code']) value="{{ $country['name'].':'.$country['dial_code'] }}" data-code="{{ $country['dial_code'] }}">{{ $country['name']  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if(getPageSetting('phone_show'))
                                <div class="single-input mb-3">
                                    <label class="input-label" for="">{{ __('Phone Number') }} @if(getPageSetting('country_validation')) <span class="text-danger">*</span> @endif</label>
                                    <div class="input-field input-group">
                                        <span class="input-group-text" id="dial-code">{{ $location->dial_code }}</span>
                                        <input type="text" name="phone" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            @endif
                            @if(getPageSetting('referral_code_show'))
                                <div class="single-input mb-3">
                                    <label class="input-label" for="">{{ __('Referral Code') }} @if(getPageSetting('referral_code_validation')) <span class="text-danger">*</span> @endif</label>
                                    <div class="input-field">
                                        <input type="text" name="invite" value="{{ old('invite',$referralCode) }}" class="box-input">
                                    </div>
                                </div>
                            @endif
                            @if(getPageSetting('gender_show'))
                                <div class="single-input mb-3">
                                    <label class="input-label" for="">{{ __('Gender') }} @if(getPageSetting('gender_validation')) <span class="text-danger">*</span> @endif</label>
                                    <select name="gender" class="box-input w-100" id="gender">
                                        @foreach(['Male','Female','Others'] as $gender)
                                            <option @selected($gender == old('gender')) value="{{ $gender }}">{{ $gender  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="single-input has-right-icon has-left-icon">
                                <label class="input-label" for="">{{ __('Password') }}<span class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="password" class="box-input password-input" name="password" required>
                                    <div class="password">
                                        <img src="{{ asset('frontend/default/images/icons/eye-off.svg') }}" class="password-hide-show eyeicon" alt="">
                                    </div>
                                    <span class="icon">
                                        <i class="icon-lock"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="single-input has-right-icon has-left-icon">
                                <label class="input-label" for="">{{ __('Confirm Password') }}<span class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="password" name="password_confirmation" class="box-input password-input" required>
                                    <div class="password">
                                        <img src="{{ asset('frontend/default/images/icons/eye-off.svg') }}" class="password-hide-show eyeicon" alt="">
                                    </div>
                                    <span class="icon">
                                        <i class="icon-lock"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="inputs">
                                <button type="submit" class="site-btn primary-btn w-100">{{ __('Create account') }}</button>
                            </div>
                        </form>
                    </div>
                    <div class="bottom-content">
                        <div class="have-acount">
                            <p>{{ __('Already have an account ') }}<a href="{{ route('login') }}">{{ __('Log In') }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="terms-user">
                    <p>{{ __('By clicking “Create account”, you agree to our') }}<a class="link" href="{{ url('/terms-and-conditions') }}">{{ __('Terms and Conditions') }}.</a></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Sign up area end -->

@endsection
@push('js')
    <script src="{{ asset('frontend/default/js/select2.min.js') }}"></script>
    <script>
        (function($) {
            'use strict';

            $('#countrySelect').select2();
            $('#gender').select2({
                minimumResultsForSearch: Infinity
            });

            // Country Select
            $('#countrySelect').on('change', function (e) {
                "use strict";
                e.preventDefault();
                var country = $(this).val();
                $('#dial-code').html(country.split(":")[1])
            })
        })(jQuery);
    </script>
@endpush