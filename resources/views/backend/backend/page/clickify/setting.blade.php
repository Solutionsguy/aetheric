@extends('backend.setting.index')
@section('setting-title')
    {{ __('Page Settings') }}
@endsection
@section('setting-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="title">{{ __('Register Field Settings') }}</h3>
                </div>
                <div class="site-card-body">
                    <form action="{{ route('admin.page.setting.update') }}" method="post"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="site-input-groups">
                            <div class="row justify-content-center">
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Username:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="username-show"
                                                name="username_show"
                                                @checked( getPageSetting('username_show'))
                                                value="1"
                                            />
                                            <label for="username-show">{{ __('Show') }}</label>
                                            <input
                                                type="radio"
                                                id="username-hide"
                                                name="username_show"
                                                @checked(!getPageSetting('username_show'))
                                                value="0"
                                            />
                                            <label for="username-hide">{{ __('Hide') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Username is:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="username-required"
                                                name="username_validation"
                                                @checked( getPageSetting('username_validation'))
                                                value="1"
                                            />
                                            <label for="username-required">{{ __('Required') }}</label>
                                            <input
                                                type="radio"
                                                id="username-optional"
                                                name="username_validation"
                                                @checked(!getPageSetting('username_validation'))
                                                value="0"
                                            />
                                            <label for="username-optional">{{ __('Optional') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label"
                                               for="">{{ __('Phone Number:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="phone-show"
                                                name="phone_show"
                                                @checked(getPageSetting('phone_show'))
                                                value="1"
                                            />
                                            <label for="phone-show">{{ __('Show') }}</label>
                                            <input
                                                type="radio"
                                                id="phone-hide"
                                                name="phone_show"
                                                @checked(!getPageSetting('phone_show'))
                                                value="0"
                                            />
                                            <label for="phone-hide">{{ __('Hide') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Phone Number is:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="phone-required"
                                                name="phone_validation"
                                                @checked( getPageSetting('phone_validation'))
                                                value="1"
                                            />
                                            <label for="phone-required">{{ __('Required') }}</label>
                                            <input
                                                type="radio"
                                                id="phone-optional"
                                                name="phone_validation"
                                                @checked(!getPageSetting('phone_validation'))
                                                value="0"
                                            />
                                            <label for="phone-optional">{{ __('Optional') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Country:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="country-show"
                                                name="country_show"
                                                @checked( getPageSetting('country_show'))
                                                value="1"
                                            />
                                            <label for="country-show">{{ __('Show') }}</label>
                                            <input
                                                type="radio"
                                                id="country-hide"
                                                name="country_show"
                                                @checked( !getPageSetting('country_show'))
                                                value="0"
                                            />
                                            <label for="country-hide">{{ __('Hide') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Country is:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="country-required"
                                                name="country_validation"
                                                @checked( getPageSetting('country_validation'))
                                                value="1"
                                            />
                                            <label for="country-required">{{ __('Required') }}</label>
                                            <input
                                                type="radio"
                                                id="country-optional"
                                                name="country_validation"
                                                @checked(!getPageSetting('country_validation'))
                                                value="0"
                                            />
                                            <label for="country-optional">{{ __('Optional') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label"
                                               for="">{{ __('Referral Code:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="referral-code-show"
                                                name="referral_code_show"
                                                @checked( getPageSetting('referral_code_show'))
                                                value="1"
                                            />
                                            <label for="referral-code-show">{{ __('Show') }}</label>
                                            <input
                                                type="radio"
                                                id="referral-code-hide"
                                                name="referral_code_show"
                                                @checked( !getPageSetting('referral_code_show'))
                                                value="0"
                                            />
                                            <label for="referral-code-hide">{{ __('Hide') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Referral code is:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="referral-code-required"
                                                name="referral_code_validation"
                                                @checked( getPageSetting('referral_code_validation'))
                                                value="1"
                                            />
                                            <label for="referral-code-required">{{ __('Required') }}</label>
                                            <input
                                                type="radio"
                                                id="referral-code-optional"
                                                name="referral_code_validation"
                                                @checked(!getPageSetting('referral_code_validation'))
                                                value="0"
                                            />
                                            <label for="referral-code-optional">{{ __('Optional') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label"
                                               for="">{{ __('Gender:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="gender-show"
                                                name="gender_show"
                                                @checked( getPageSetting('gender_show'))
                                                value="1"
                                            />
                                            <label for="gender-show">{{ __('Show') }}</label>
                                            <input
                                                type="radio"
                                                id="gender-hide"
                                                name="gender_show"
                                                @checked( !getPageSetting('gender_show'))
                                                value="0"
                                            />
                                            <label for="gender-hide">{{ __('Hide') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-12 col-12">
                                    <div class="site-input-groups">
                                        <label class="box-input-label" for="">{{ __('Gender is:') }}</label>
                                        <div class="switch-field">
                                            <input
                                                type="radio"
                                                id="gender-required"
                                                name="gender_validation"
                                                @checked( getPageSetting('gender_validation'))
                                                value="1"
                                            />
                                            <label for="gender-required">{{ __('Required') }}</label>
                                            <input
                                                type="radio"
                                                id="gender-optional"
                                                name="gender_validation"
                                                @checked(!getPageSetting('gender_validation'))
                                                value="0"
                                            />
                                            <label for="gender-optional">{{ __('Optional') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="site-btn-sm primary-btn">{{ __('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
