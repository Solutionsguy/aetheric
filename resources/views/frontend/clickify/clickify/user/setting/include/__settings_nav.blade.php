<div class="ads-step">
    <div class="ads-step-inner">
        <a class="step-btn {{ Route::is('user.setting.show') ? 'is-active' : '' }}" href="{{ route('user.setting.show') }}">{{ __('Settings') }}</a>
        <a class="step-btn {{ Route::is('user.change.password') ? 'is-active' : '' }}" href="{{ route('user.change.password') }}">{{ __('Change Password') }}</a>
        @if(setting('kyc_verification','permission'))
        <a class="step-btn {{ Route::is('user.kyc') ? 'is-active' : '' }}" href="{{ route('user.kyc') }}">{{ __('ID Verification') }}</a>
        @endif
    </div>
</div>