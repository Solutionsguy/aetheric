@if($user->kyc == \App\Enums\KYCStatus::NOT_SUBMITTED->value || $user->kyc == \App\Enums\KYCStatus::Failed->value )
<div class="col-xxl-12 mb-4">
    <div class="identity-alert pending">
        <div class="icon">
            <i class="far fa-warning"></i>
        </div>
        <div class="contents">
            <div class="head">{{ __('Verification Center') }}</div>
            <div class="content">
                {{ __('You need to submit your KYC before proceed to the system') }}
                <a href="{{ route('user.kyc') }}" class="underline-btn">
                    {{ __('Submit Now') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif
