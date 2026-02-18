@extends('frontend::layouts.user')
@section('title')
{{ __('Change Password') }}
@endsection
@section('content')
<div class="profile-change-password-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            @include('frontend::user.setting.include.__settings_nav')
        </div>
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="site-card-title">{{ __('Change Password') }}</h3>
                </div>
                <div class="profile-change-password-from">
                    <form action="{{ route('user.new.password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6">
                                <div class="single-input has-right-icon">
                                    <label class="input-label" for="">{{ __('Current Password') }}</label>
                                    <div class="input-field">
                                        <input type="password" class="box-input password-input" name="current_password">
                                        <div class="password">
                                            <img src="{{ asset('frontend/default/images/icons/eye-off.svg') }}"
                                                class="password-hide-show eyeicon" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="single-input has-right-icon">
                                    <label class="input-label" for="">{{ __('New Password') }}</label>
                                    <div class="input-field">
                                        <input type="password" class="box-input password-input" name="new_password">
                                        <div class="password">
                                            <img src="{{ asset('frontend/default/images/icons/eye-off.svg') }}"
                                                class="password-hide-show eyeicon" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="single-input has-right-icon">
                                    <label class="input-label" for="">{{ __('Confirm Password') }}</label>
                                    <div class="input-field">
                                        <input type="password" class="box-input password-input"
                                            name="new_confirm_password">
                                        <div class="password">
                                            <img src="{{ asset('frontend/default/images/icons/eye-off.svg') }}"
                                                class="password-hide-show eyeicon" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="button-inner">
                                    <div class="btn-wrap">
                                        <button class="site-btn primary-btn" type="submit">
                                            <span>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="10" cy="10" r="10" fill="white" fill-opacity="0.2" />
                                                    <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            {{ __('Change Password') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    (function ($) {
        'use strict';

        // password hide show
        let eyeicons = document.querySelectorAll('.eyeicon');
        let passwords = document.querySelectorAll('.password-input');

        eyeicons.forEach(function (eyeicon, index) {
            eyeicon.onclick = function () {
                if (passwords[index].type === "password") {
                    passwords[index].type = "text";
                    eyeicon.src = '{{ asset("frontend/default/images/icons/eye.svg") }}';
                } else {
                    passwords[index].type = "password";
                    eyeicon.src = '{{ asset("frontend/default/images/icons/eye-off.svg") }}';
                }
            };
        });

    })(jQuery);

</script>
@endpush
