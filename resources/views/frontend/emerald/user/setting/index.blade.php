@extends('frontend::layouts.user')
@section('title')
{{ __('Settings') }}
@endsection
@section('content')
<div class="row">
    <div class="pofile-setting-area">
        @include('frontend::user.setting.include.__settings_nav')
        <div class="row gy-30">
            <div class="col-xxl-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('Profile Settings') }}</h3>
                    </div>
                    <form action="{{ route('user.setting.profile-update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="pofile-setting-wrapper">
                            <div class="profile-info-content">
                                <div class="thumb">
                                    @if(auth()->user()->avatar != null &&
                                    file_exists(base_path('assets/'.auth()->user()->avatar)))
                                    <img id="profileImage" src="{{ asset($user->avatar) }}" alt="Profile Image"
                                        width="125" height="125">
                                    @else
                                    <img id="profileImage" src="{{ asset('frontend/images/user.jpg') }}"
                                        alt="Profile Image" width="125" height="125">
                                    @endif
                                </div>
                                <div class="content">
                                    <div class="profile-upload-img">
                                        <!-- Label for the file input -->
                                        <label for="imageInput"
                                            class="upload-label">{{ __('Change Profile Photo') }}</label>
                                        <!-- File input element -->
                                        <input type="file" name="avatar" id="imageInput" accept="image/*"
                                            style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="profile-information">
                                <h4 class="title">{{ __('Personal Information') }}</h4>
                                <div class="row gy-20">
                                    <div class="col-xxl-6 col-md-6">
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('First Name') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="box-input" name="first_name"
                                                    value="{{ $user->first_name }}">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Last Name') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="box-input" name="last_name"
                                                    value="{{ $user->last_name }}">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Username') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="box-input" name="username"
                                                    value="{{ $user->username }}">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Date of Birth') }}</label>
                                            <div class="input-field disabled">
                                                <input type="date" value="{{ $user->date_of_birth }}"
                                                    name="date_of_birth">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Zip Code') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="box-input" name="zip_code"
                                                    value="{{ $user->zip_code }}">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Address') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="box-input" name="address"
                                                    value="{{ $user->address }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-md-6">
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Email Address') }}</label>
                                            <div class="input-field disabled">
                                                <input type="email" class="box-input" name="email"
                                                    value="{{ $user->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Phone Number') }}</label>
                                            <div class="input-field">
                                                <input type="tel" class="box-input" name="phone"
                                                    value="{{ $user->phone }}">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Gender') }}</label>
                                            <div class="input-select">
                                                <select name="gender">
                                                    @foreach(['Male','Female','Other'] as $gender)
                                                    <option value="{{$gender}}" @selected($user->gender ==
                                                        $gender)>{{$gender}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Country') }}</label>
                                            <div class="input-field disabled">
                                                <input type="text" class="box-input" name="country"
                                                    value="{{ $user->country }}" disabled>
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('City') }}</label>
                                            <div class="input-field">
                                                <input type="text" class="box-input" name="city"
                                                    value="{{ $user->city }}">
                                            </div>
                                        </div>
                                        <div class="single-input">
                                            <label class="input-label" for="">{{ __('Joining Date') }}</label>
                                            <div class="input-field disabled">
                                                <input type="text" class="box-input" required
                                                    placeholder="{{ $user->created_at }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12">
                                        <div class="input-btn-wrap">
                                            <button class="input-btn btn-primary" type="submit"><span>
                                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="10" cy="10" r="10" fill="white"
                                                            fill-opacity="0.2" />
                                                        <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </span>{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(setting('fa_verification'))
            <div class="col-xxl-12">
                <div class="site-card">
                    <div class="two-factor-auth-main">
                        <div class="site-card-header">
                            <h3 class="site-card-title">{{ __('Two Factor Authentication') }}</h3>
                        </div>
                        <div class="two-factor-auth-wrapper">
                            @if($user->google2fa_secret !== null)
                            @php
                            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

                            $inlineUrl =
                            $google2fa->getQRCodeInline(setting('site_title','global'),$user->email,$user->google2fa_secret);
                            @endphp

                            <div class="qr-code">
                                @if(Str::of($inlineUrl)->startsWith('data:image/'))
                                <img src="{{ $inlineUrl }}">
                                @else
                                {!! $inlineUrl !!}
                                @endif
                            </div>
                            <form action="{{ route('user.setting.action-2fa') }}" method="POST">
                                @csrf

                                <div class="single-input">
                                    <label for="" class="input-label">
                                        @if($user->two_fa)
                                        {{ __('Enter Your Password') }}
                                        @else
                                        {{ __('Enter the PIN from Google Authenticator App') }}
                                        @endif
                                    </label>
                                    <div class="input-field">
                                        <input type="password" class="box-input" name="one_time_password">
                                    </div>
                                </div>

                                @if($user->two_fa)
                                <button type="submit" class="site-btn danger-btn text-white" value="disable"
                                    name="status">
                                    <i data-lucide="x-circle"></i> {{ __('Disable 2FA') }}
                                </button>
                                @else
                                <button type="submit" class="site-btn primary-btn mt-4" value="enable" name="status">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="10" cy="10" r="10" fill="white" fill-opacity="0.2" />
                                        <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> {{ __('Enable 2FA') }}
                                </button>
                                @endif

                            </form>
                            @else
                            <a href="{{ route('user.setting.2fa') }}" class="site-btn primary-btn">
                                <span>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="10" cy="10" r="10" fill="white" fill-opacity="0.2" />
                                        <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                {{ __('Generate Key') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-xxl-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <h3 class="site-card-title">{{ __('Account Closing ') }}</h3>
                    </div>
                    <div class="account-close-content">
                        <p class="description">
                            {{ __('If you want to delete account then click on "Close My Account" button but') }}</p>
                        <div class="attention">
                            <div class="icon">
                                <span><svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.57465 2.21635L1.51632 13.9997C1.37079 14.2517 1.29379 14.5374 1.29298 14.8284C1.29216 15.1195 1.36756 15.4056 1.51167 15.6585C1.65579 15.9113 1.86359 16.122 2.11441 16.2696C2.36523 16.4171 2.65032 16.4965 2.94132 16.4997H17.058C17.349 16.4965 17.6341 16.4171 17.8849 16.2696C18.1357 16.122 18.3435 15.9113 18.4876 15.6585C18.6317 15.4056 18.7071 15.1195 18.7063 14.8284C18.7055 14.5374 18.6285 14.2517 18.483 13.9997L11.4247 2.21635C11.2761 1.97144 11.0669 1.76895 10.8173 1.62842C10.5677 1.48789 10.2861 1.41406 9.99965 1.41406C9.71321 1.41406 9.43159 1.48789 9.18199 1.62842C8.93238 1.76895 8.72321 1.97144 8.57465 2.21635Z"
                                            stroke="#FF8112" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M10 6.5V9.83333" stroke="#FF8112" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10 13.1665H10.01" stroke="#FF8112" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <p class="attention-text">
                                {{ __('Once this account is deleted you will not get this account back unless you contact our support team.') }}
                            </p>
                        </div>
                        <button type="button" class="input-btn btn-danger disable" data-bs-toggle="modal" data-bs-target="#profileDelete"><i class="icon-close-circle"></i>
                            {{ __('Close My Account') }}
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="profileDelete" tabindex="-1" aria-labelledby="profileDeleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog profile-delete-modal modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body popup-body">
                                <button type="button" class="modal-btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="icon-close-circle"></i></button>
                                <div class="profile-modal-wrapper text-center">
                                    <div class="close-content" data-background="{{ asset('frontend/default/images/bg/close-bg.png') }}">
                                        <span class="close">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 2L2 18" stroke="#EE2D42" stroke-width="3"
                                                    stroke-linecap="round" />
                                                <path d="M18 18L2 2" stroke="#EE2D42" stroke-width="3"
                                                    stroke-linecap="round" />
                                            </svg>
                                        </span>
                                        <h3>{{ __('Are you sure you want to close this account?') }}</h3>
                                    </div>
                                    <div class="bottom-content">
                                        <form action="{{ route('user.setting.close.account') }}" method="post">
                                            @csrf
                                            <p class="description">{{ __('If you close this account and reopening by the support.') }}</p>
                                            <div class="btn-wrap justify-content-center">
                                                <button type="submit" class="site-btn danger-btn">
                                                    <span>
                                                        <svg width="20" height="20"
                                                                viewBox="0 0 20 20" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="10" cy="10" r="10" fill="white"
                                                                    fill-opacity="0.2" />
                                                                <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>{{ __('Close Now') }}
                                                </button>
                                                <button type="button" class="site-btn danger-btn disable" data-bs-dismiss="modal"
                                                    aria-label="Close"><i class="icon-close-circle"></i>{{ __('Cancel') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    "use strict";

    document.getElementById('imageInput').addEventListener('change', function () {
        var file = this.files[0];
        var image = document.getElementById('profileImage');
        image.src = window.URL.createObjectURL(file);
    });

</script>
@endpush
