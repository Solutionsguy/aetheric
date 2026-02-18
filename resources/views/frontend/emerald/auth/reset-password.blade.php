@extends('frontend::layouts.auth')
@section('title')
    {{ __('Reset Password') }}
@endsection
@section('content')


<!-- Reset Password start -->
<section class="sign-area">
    <div class="auth-wrapper">
        <div class="contents-inner">
            <div class="content">
                <div class="top-content">
                    <h3 class="title">{{ __('Reset password') }}</h3>
                    <p>{{  __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>
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

                    @if(session('status'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session('status') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="single-input has-left-icon">
                            <label class="input-label" for="">{{ __('Email Address') }}<span class="text-danger">*</span></label>
                            <div class="input-field">
                                <input type="email" name="email" class="box-input email-input" required value="{{ request('email') }}" placeholder="{{ __('Enter email') }}">
                                <span class="icon">
                                    <i class="icon-sms"></i>
                                </span>
                            </div>
                        </div>
                        <div class="single-input has-right-icon has-left-icon">
                            <label class="input-label" for="">{{ __('Password') }}<span class="text-danger">*</span></label>
                            <div class="input-field">
                                <input type="password" name="password" class="box-input password-input" required
                                    placeholder="{{ __('Enter password') }}">
                                <div class="password">
                                    <img src="{{ asset('frontend/images/icons/eye-off.svg') }}" class="password-hide-show eyeicon"
                                        alt="">
                                </div>
                                <span class="icon">
                                    <i class="icon-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="single-input has-right-icon has-left-icon">
                            <label class="input-label" for="">{{ __('Confirm Password') }}<span class="text-danger">*</span></label>
                            <div class="input-field">
                                <input type="password" name="password_confirmation" class="box-input password-input" required
                                    placeholder="{{ __('Enter password') }}">
                                <div class="password">
                                    <img src="{{ asset('frontend/images/icons/eye-off.svg') }}" class="password-hide-show eyeicon"
                                        alt="">
                                </div>
                                <span class="icon">
                                    <i class="icon-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="inputs">
                            <button type="submit" class="site-btn primary-btn w-100">{{ __('Reset Password') }}</button>
                        </div>
                        <div class="bottom-content">
                            <div class="have-acount">
                                <p>{{ __('Don\'t have an account?') }}<a href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Reset Password end -->
@endsection

