@extends('frontend::layouts.auth')
@section('title')
    {{ __('Forgot password') }}
@endsection
@section('content')
    <!-- Forget password area start -->
    <section class="forget-password-area">
        <div class="auth-wrapper vh-100">
            <div class="contents-inner">
                <div class="content">
                    <div class="top-content">
                        <h3 class="title">{{ $data['title'] }}</h3>
                    </div>
                    <div class="auth-form-wrapper">

                        @if(session('status'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>{{ session('status') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf

                            <div class="single-input has-left-icon">
                                <label class="input-label" for="">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <div class="input-field">
                                    <input type="email" name="email" class="box-input email-input" required
                                        placeholder="{{ __('Enter email') }}">
                                    <span class="icon">
                                        <i class="icon-sms"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="inputs mb-0">
                                <button type="submit" class="site-btn primary-btn w-100">{{ __('Get Reset Link') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Forget password area end -->
@endsection


