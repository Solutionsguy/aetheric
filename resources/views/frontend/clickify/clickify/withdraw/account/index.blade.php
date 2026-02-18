@extends('frontend::layouts.user')
@section('title')
{{ __('Withdraw Account') }}
@endsection
@section('content')
<div class="withdraw-area">
    <div class="withdraw-history-content">
        <div class="row gy-30">
            <div class="col-xxl-12">
                <div class="site-card">
                    <div class="site-card-header">
                        <div class="site-title-inner">
                            <h3 class="site-card-title mb-0">{{ __('Withdraw Account') }}</h3>
                            <button button class="site-btn primary-btn" data-bs-toggle="modal"
                                data-bs-target="#withdrawNewAccount"><i class="icon-directbox-send"></i>Add New</button>
                        </div>
                    </div>
                    <div class="withdraw-history-table">
                        <div class="site-custom-table-wrapper overflow-x-auto">
                            <div class="site-custom-table">
                                <div class="contents">
                                    <div class="site-table-list site-table-head">
                                        <div class="site-table-col">{{ __('Account') }}</div>
                                        <div class="site-table-col">{{ __('Action') }}</div>
                                    </div>
                                    @foreach ($accounts as $account)
                                    <div class="site-table-list">
                                        <div class="site-table-col">
                                            <div class="found-history-description">
                                                <div class="icon">
                                                    <i class="icon-profile-circle"></i>
                                                </div>
                                                <div class="content">
                                                    <h3 class="title">{{ $account->method_name }}</h3>
                                                    <p class="date">{{ $account->method->currency .' '. __('Account') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="site-table-col">
                                            <div class="action-btn-wrap">
                                                <button class="action-btn primary-btn edit-btn" data-id="{{ encrypt($account->id) }}" data-bs-toggle="modal"><i
                                                        class="icon-edit-2"></i>
                                                </button>
                                                <button class="action-btn danger-btn delete-btn"
                                                    data-id="{{ encrypt($account->id) }}" data-bs-toggle="modal"
                                                    data-bs-target="#withdrawDeleteAcount"><i
                                                        class="icon-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if(count($accounts) == 0)
                                <div class="no-data-found">{{ __('No Data Found') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal withdraw new account start-->
<div class="modal fade" id="withdrawNewAccount" tabindex="-1" aria-labelledby="withdrawNewAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog withdraw-add-modal modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="icon-close-circle"></i></button>
                <div class="modal-content-wrapper">
                    <h3 class="title">{{ __('Add New Withdrawal Account') }}</h3>
                    <form action="{{ route('user.withdraw.account.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="withdraw-add-from">
                            <div class="single-input">
                                <label class="input-label" for="">{{ __('Gateway') }}</label>
                                <div class="input-select">
                                    <select name="withdraw_method_id" id="selectMethod">
                                        <option disabled selected>{{ __('Select Gateway') }}</option>
                                        @foreach($withdrawMethods as $raw)
                                            <option value="{{ $raw->id }}">{{ $raw->name }}
                                                ({{ ucwords($raw->type) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="manual-row">

                            </div>
                        </div>
                        <div class="bottom-content">
                            <div class="btn-wrap">
                                <button type="submit" class="site-btn primary-btn"><i class="icon-add-circle"></i>
                                    {{ __('Add New Withdraw Account') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal withdraw new account end-->

<!-- Modal withdraw new account start-->
<div class="modal fade" id="editWithdrawAccount" tabindex="-1" aria-labelledby="editWithdrawAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog withdraw-add-modal modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="icon-close-circle"></i></button>
                <div class="modal-content-wrapper">
                    <h3 class="title">{{ __('Edit Withdrawal Account') }}</h3>
                    <form action="" method="POST" enctype="multipart/form-data" id="edit-form">
                        @csrf
                        @method('PUT')
                        <div class="withdraw-add-from">
                            <div class="edit-manual-row">

                            </div>
                        </div>
                        <div class="bottom-content">
                            <div class="btn-wrap">
                                <button type="submit" class="site-btn primary-btn"><i class="icon-add-circle"></i>
                                    {{ __('Update Withdraw Account') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal withdraw new account end-->

<!-- Modal withdraw Delete Acount start-->
<div class="modal fade" id="withdrawDeleteAcount" tabindex="-1" aria-labelledby="withdrawDeleteAcountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog profile-delete-modal modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="icon-close-circle"></i>
                </button>
                <div class="profile-modal-wrapper text-center">
                    <form action="" method="post" id="delete-account">
                        @csrf
                        <div class="close-content"
                            data-background="{{ asset('frontend/default/images/bg/close-bg.png') }}">
                            <span class="close">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 2L2 18" stroke="#EE2D42" stroke-width="3" stroke-linecap="round" />
                                    <path d="M18 18L2 2" stroke="#EE2D42" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </span>
                            <h3>{{ __('Are you sure you want to delete this account?') }}</h3>
                        </div>
                        <div class="bottom-content">
                            <p class="description"></p>
                            <div class="alert-text">
                            </div>
                            <div class="btn-wrap justify-content-center">
                                <button type="submit" class="site-btn danger-btn">
                                    <span>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="10" cy="10" r="10" fill="white" fill-opacity="0.2" />
                                            <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    {{ __('Delete') }}
                                </button>
                                <button class="site-btn danger-btn disable" type="button" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="icon-close-circle"></i>{{ __('Cancel') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal withdraw Delete Acount end-->
@push('js')
<script>
    "use strict";

    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        var url = "{{ url('user/withdraw/account/delete') }}/" + id;
        $('#delete-account').attr('action', url);
    });

    $(document).on('click', '.edit-btn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{ route('user.withdraw.account.edit',['account' => ':id']) }}";
        url = url.replace(':id',id);

        var formUrl = "{{ route('user.withdraw.account.update',['account' => ':id']) }}";
        $('#edit-form').attr('action', formUrl.replace(':id',id));

        $.get(url,function(response){
            $('.edit-manual-row').html(response.html);
            $('#editWithdrawAccount').modal('show');
        })
    });

    $("#selectMethod").on('change', function (e) {
        "use strict";

        e.preventDefault();
        var id = $(this).val()

        var url = '{{ route("user.withdraw.method",":id") }}';
        url = url.replace(':id', id);

        $.get(url, function (data) {
            $('.manual-row').html(data);
        })
    });

</script>
@endpush
@endsection
