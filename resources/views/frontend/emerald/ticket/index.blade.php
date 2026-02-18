@extends('frontend::layouts.user')
@section('title')
{{ __('My Ticket List') }}
@endsection
@push('style')
<link rel="stylesheet" href="{{ asset('frontend/default/css/daterangepicker.css') }}">
@endpush
@section('content')
<div class="withdraw-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="site-title-inner">
                        <h3 class="site-card-title mb-0">{{ __('My Ticket List') }}</h3>
                        <button button class="site-btn primary-btn" data-bs-toggle="modal"
                            data-bs-target="#createTicket"><i class="icon-add-circle"></i>
                            {{ __('Create Ticket') }}
                        </button>
                    </div>
                </div>
                <div class="support-ticket-form">
                    <form method="GET">
                        <div class="support-ticket-form-grid">
                            <div class="input-field">
                                <input type="text" class="box-input" name="subject" required
                                    placeholder="{{ __('Subject') }}" value="{{ request('subject') }}">
                            </div>
                            <div class="input-field">
                                <input type="text" name="daterange" placeholder="{{ __('Date') }}"
                                    value="{{ request('daterange') }}" autocomplete="off">
                            </div>
                            <button class="site-btn primary-btn" type="submit">
                                <i class="icon-search-normal"></i>{{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="withdraw-history-table">
                    <div class="site-custom-table-wrapper overflow-x-auto">
                        <div class="site-custom-table">
                            <div class="contents">
                                <div class="site-table-list site-table-head">
                                    <div class="site-table-col">{{ __('Ticket') }}</div>
                                    <div class="site-table-col">{{ __('Precedence') }}</div>
                                    <div class="site-table-col">{{ __('Last Open') }}</div>
                                    <div class="site-table-col">{{ __('Status') }}</div>
                                    <div class="site-table-col">{{ __('Action') }}</div>
                                </div>

                                @foreach ($tickets as $ticket)
                                <div class="site-table-list">
                                    <div class="site-table-col">
                                        <div class="found-history-description">
                                            <div class="icon">
                                                <i class="icon-directbox-send"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title">
                                                    <a href="{{ route('user.ticket.show',$ticket->uuid) }}">
                                                        [{{ __('Ticket') }} - {{ $ticket->uuid }}] {{ $ticket->title }}
                                                    </a>
                                                </div>
                                                <div class="date">{{ $ticket->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($ticket->priority == 'low')
                                        <div class="type site-badge badge-pending">{{ $ticket->priority }}</div>
                                        @elseif($ticket->priority == 'high')
                                        <div class="type site-badge badge-primary">{{ $ticket->priority }}</div>
                                        @else
                                        <div class="type site-badge badge-success">{{ $ticket->priority }}</div>
                                        @endif
                                    </div>
                                    <div class="site-table-col">
                                        <div class="trx fw-bold">
                                            {{ $ticket->messages->last()?->created_at->diffForHumans() ?? '--' }}
                                        </div>
                                    </div>
                                    <div class="site-table-col">
                                        @if($ticket->isOpen())
                                        <span class="ms-2 status site-badge badge-primary">{{ __('Opened') }}</span>
                                        @elseif($ticket->isClosed())
                                        <span class="ms-2 status site-badge badge-failed">{{ __('Closed') }}</span>
                                        @endif
                                    </div>
                                    <div class="site-table-col">
                                        <div class="action-btn-wrap">
                                            <a href="{{ route('user.ticket.show',$ticket->uuid) }}" class="action-btn primary-btn"><i class="icon-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if(count($tickets) == 0)
                                @include('frontend::user.include.__no_data_found')
                            @endif
                        </div>
                    </div>
                    {{ $tickets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal create Tricke start-->
<div class="modal fade" id="createTicket" tabindex="-1" aria-labelledby="createTicketModalLabel"
    aria-hidden="true">
    <div class="modal-dialog create-ticket-modal modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body popup-body">
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="icon-close-circle"></i></button>
                <div class="modal-content-wrapper">
                    <h3 class="title">{{ __('Create a New Ticket') }}</h3>
                    <form action="{{ route('user.ticket.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="create-ticket-from">
                            <div class="single-input">
                                <label class="input-label" for="">{{ __('Subject') }}<span>*</span></label>
                                <div class="input-field">
                                    <input type="text" class="box-input" name="title" required>
                                </div>
                            </div>
                            <div class="single-input">
                                <label class="input-label" for="">{{ __('Precedence') }}<span>*</span></label>
                                <div class="input-select">
                                    <select name="priority">
                                        <option value="" selected disabled>{{ __('Select precedence') }}</option>
                                        <option value="low">{{ __('Low') }}</option>
                                        <option value="medium">{{ __('Medium') }}</option>
                                        <option value="high">{{ __('High') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="single-input">
                                <label class="input-label" for="">{{ __('Message') }}<span>*</span></label>
                                <div class="input-field">
                                    <textarea name="message" required></textarea>
                                </div>
                            </div>
                            <div class="file-upload-wrap">
                                <div class="top-content">
                                    <label class="input-label">{{ __('Upload Image') }}</label>
                                    <button type="button" id="addBtn" class="site-btn primary-btn btn-xxs"> <i
                                            class="icon-add-circle"></i> {{ __('Add') }}</button>
                                </div>
                                <div id="uploadItems">
                                    <div class="upload-custom-file">
                                        <input type="file" name="attachments[]" class="upload-input"
                                            accept=".gif, .jpg, .png" id="image1">
                                        <label for="image1">
                                            <img class="upload-icon" src="{{ asset('frontend/default/images/icons/cloud-plus.svg') }}"
                                                alt="upload image">
                                            <span><b>{{ __('Attach Image') }}</b>{{ __(' Or Drag and Drop') }}</span>
                                            <span class="type-file-text">
                                                <small>{{ __('Attach JPEG/PNG file') }}</small>
                                            </span>
                                        </label>
                                        <button type="button" class="file-upload-close">
                                            <i class="icon-close-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-wrap">
                            <button type="submit" class="site-btn primary-btn"><i class="icon-add-circle"></i>
                                {{ __('Create Ticket') }}
                            </button>
                            <button type="button" class="site-btn danger-btn disable" data-bs-dismiss="modal"
                                aria-label="Close"><i class="icon-close-circle"></i>{{ __('Close') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal create Tricke end-->
@endsection
@push('js')
<script src="{{ asset('frontend/default/js/moment.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/daterangepicker.min.js') }}"></script>
<script>
    // Initialize datepicker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    });

    @if(request('daterange') == null)
    // Set default is empty for date range
    $('input[name=daterange]').val('');
    @endif

    $(document).ready(function () {
      // Function to handle file input change event
      function handleFileInputChange(event) {
        var $file = $(this),
          $label = $file.closest('label'),
          $labelText = $label.find('span').first(),
          labelDefault = $labelText.text();

        var fileName = $file.val().split('\\').pop(),
          tmppath = URL.createObjectURL(event.target.files[0]);

        if (fileName) {
          $label.addClass('file-ok').css('background-image', 'url(' + tmppath + ')');
          $labelText.text(fileName);
        } else {
          $label.removeClass('file-ok');
          $labelText.text(labelDefault);
        }
      }

      // Function to handle click on file-upload-close button
      function handleFileUploadClose() {
        $(this).closest('.upload-custom-file').remove();
      }

      // Add event listener for adding new upload item
      $('#addBtn').on('click', function () {
        var uniqueId = 'image' + ($('.upload-custom-file').length + 1); // Generate unique ID for this upload item

        var uploadItem = $('<div class="upload-custom-file">' +
          '<input type="file" name="attachments[]" class="upload-input" accept=".gif, .jpg, .png" id="' + uniqueId + '" />' +
          '<label for="' + uniqueId + '">' +
          '<img class="upload-icon" src="{{ asset('frontend/default/images/icons/cloud-plus.svg') }}" alt="upload image">' +
          '<span> <b>Attach Image </b> Or Drag and Drop</span>' +
          '<span class="type-file-text"><small>Attach JPEG/PNG/PDF/Docs file</small></span>' +
          '</label>' +
          '<button type="button" class="file-upload-close"><i class="icon-close-circle"></i></button>' +
          '</div>');

        // Bind change event to the input field within the newly added upload item
        uploadItem.find('.upload-input').on('change', handleFileInputChange);

        // Bind click event to the file-upload-close button
        uploadItem.find('.file-upload-close').on('click', handleFileUploadClose);

        $('#uploadItems').append(uploadItem);
      });

      // Attach event listener for file input change for existing upload items
      $(document).on('change', '.upload-input', handleFileInputChange);

      // Attach event listener for file-upload-close button for existing upload items
      $(document).on('click', '.file-upload-close', handleFileUploadClose);
    });

</script>
@endpush
