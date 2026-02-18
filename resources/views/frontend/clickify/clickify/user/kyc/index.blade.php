@extends('frontend::layouts.user')
@section('title')
{{ __('KYC') }}
@endsection
@section('content')
<div class="notifications-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            @include('frontend::user.setting.include.__settings_nav')
        </div>
        @if($user->kyc == \App\Enums\KYCStatus::Verified->value)
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="identity-alert approved">
                        <div class="icon">
                            <i class="far fa-check-circle text-success"></i>
                        </div>
                        <div class="contents">
                            <div class="head">{{ __('Verification Center') }}</div>
                            <div class="content">
                                {{ __('You have submitted your documents and it is verified') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="site-card-title">{{ __('Verification Center') }}</h3>
                </div>
                <div class="input-btn-wrap">
                    <div class="input-btn-wrap">
                        @forelse($kycs as $kyc)
                        <a class="site-btn primary-btn" href="{{ route('user.kyc.submission',encrypt($kyc->id)) }}">
                            {{ $kyc->name }}</a>
                        @empty
                        <p class="mb-0">
                            <i>{{ __('You have nothing to submit') }}</i>
                        </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <h3 class="site-card-title">{{ __('KYC History') }}</h3>
                </div>
                @foreach($user_kycs as $kyc)
                <div @class(['identity-alert mb-3' , 
                        'pending'=> $kyc->status == 'pending',
                        'not-approved' => $kyc->status == 'rejected',
                        'approved' => $kyc->status == 'approved'
                    ])>
                    <div class="contents">
                        <div class="content">
                            <strong>{{ $kyc->kyc?->name ?? $kyc->type }}</strong> is @if($kyc->status ==
                            'pending')
                            <div class="type site-badge badge-pending">{{ ucfirst($kyc->status) }}</div>
                            @elseif($kyc->status == 'rejected')
                            <div class="type site-badge badge-failed ">{{ ucfirst($kyc->status) }}</div>
                            @elseif($kyc->status == 'approved')
                            <div class="type site-badge badge-success">{{ ucfirst($kyc->status) }}</div>
                            @endif
                            <a href="javascript:void(0)" class="underline-btn ms-2" id="openModal" data-id="{{ $kyc->id }}">
                                {{ __('View Details') }}</a>
                            <br>
                            <small><i>{{ __('Submission Date:') }}
                                    {{ $kyc->created_at->format('d M Y h:i A') }}</i></small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="kyc" tabindex="-1" aria-labelledby="kycModalLabel" aria-hidden="true">
    <div class="modal-dialog create-ticket-modal modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="icon-close-circle"></i></button>
                <div class="modal-content-wrapper">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).on('click', '#openModal', function () {
        "use strict";

        let id = $(this).data('id');

        $.get("{{ route('user.kyc.details') }}", {
            id: id
        }, function (response) {
            $('.modal-content-wrapper').html(response.html);
            $('#kyc').modal('show');
        });

    });

</script>
@endpush
