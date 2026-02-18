@extends('frontend::layouts.user')
@section('title')
{{ __('View Ticket') }}
@endsection
@section('content')
<div class="withdraw-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                        <h4 class="site-card-title mb-0"> 
                            {{ $ticket->title.' - '.$ticket->uuid }}

                            @if($ticket->isOpen())
                            <span class="site-badge badge-primary">{{ __('Opened') }}</span>
                            @elseif($ticket->isClosed())
                            <span class="site-badge badge-failed">{{ __('Closed') }}</span>
                            @endif
                         </h4>

                         @if($ticket->isOpen())
                         <a href="" class="site-btn danger-btn" data-bs-toggle="modal"
                             data-bs-target="#closeTicket">
                             <i data-lucide="x"></i> {{ __('Close Ticket') }}
                         </a>
                         @else
                         <a href="#" class="site-btn primary-btn" data-bs-toggle="modal" data-bs-target="#reopenTicket">
                             <i data-lucide="check"></i> {{ __('Reopen Ticket') }}
                         </a>
                         @endif
                    </div>
                </div>
                @if($ticket->isOpen())
                <div class="support-form">
                    <form action="{{ route('user.ticket.reply',$ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="uuid" value="{{ $ticket->uuid }}">
                        <div class="row gy-3">
                            <div class="col-xxl-12">
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
                            <div class="col-xxl-12">
                                <div class="single-input">
                                    <label class="input-label" for="">{{ __('Write Reply') }}</label>
                                    <div class="input-field">
                                        <textarea name="message"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12">
                                <button class="input-btn btn-primary">{{ __('Send Reply') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="support-tickets-wrapper">
                    <div class="support-tickets-grid">
                        @foreach($ticket->messages as $message )
                        <div class="support-tickets-item {{ $message->model == 'user' ? 'right-item' : '' }} ">
                            <div class="support-tickets-aviator">
                                <div class="thumb">
                                    @if( $message->model != 'admin')
                                    <img src="{{ asset($ticket->user->avatar ?? 'global/materials/user.png' )}}" alt=""
                                        height="40" width="40">
                                    @else
                                    <img src="{{ asset($message->user->avatar ?? 'global/materials/user.png' )}}" alt=""
                                        height="40" width="40">
                                    @endif
                                </div>
                                <div class="contents">
                                    @if($message->model != 'admin')
                                    <h5 class="title">{{ $user->full_name }}</h5>
                                    <span class="info">{{ $user->email }}</span>
                                    @else
                                    <h5 class="title">{{ $message->user->name }}</h5>
                                    @endif
                                </div>
                            </div>
                            <div class="support-tickets-card">
                                <div class="message-body">
                                    <div class="article">
                                       {{ $message->message }}
                                    </div>
                                </div>
                                @php
                                $attachments = json_decode($message->attachments);
                                @endphp

                                @if(is_array($attachments) && count($attachments) > 0)
                                <div class="message-attachments">
                                    <div class="title">{{ __('Attachments') }}</div>
                                    <div class="single-attachment">
                                        @foreach ($attachments as $attachment)
                                        <div class="attach">
                                            <a href="{{ asset($attachment) }}" target="_blank">
                                                <i data-lucide="image"></i> {{ substr($attachment,14) }}
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <div class="support-tickets-item right-item">
                            <div class="support-tickets-aviator">
                                <div class="thumb">
                                    <img src="{{ asset($ticket->user->avatar ?? 'global/materials/user.png' )}}" alt="support-tickets-avater">
                                </div>
                                <div class="contents">
                                    <h5 class="title">{{ $user->full_name }}</h5>
                                    <span class="info">{{ $user->email }}</span>
                                </div>
                            </div>
                            <div class="support-tickets-card">
                                <div class="message-body">
                                   {{ $ticket->message }}
                                </div>

                                @php
                                $ticket_attachments = $ticket->attachments;
                                @endphp
        
                                @if(is_array($ticket_attachments) && count($ticket_attachments) > 0)
                                <div class="message-attachments">
                                    <div class="title">{{ __('Attachments') }}</div>
                                    <div class="single-attachment">
                                        @foreach ($ticket_attachments as $attachment)
                                        <div class="attach">
                                            <a href="{{ asset($attachment) }}" target="_blank"><i class="anticon anticon-picture"></i>{{ substr($attachment,14) }}</a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="closeTicket" tabindex="-1" aria-labelledby="closeTicketModalLabel" aria-hidden="true">
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
                            <h3>{{ __('Are you sure?') }}</h3>
                        </div>
                        <div class="bottom-content">
                            <p class="description">{{ __('You want to close this Ticket?') }}</p>
                            <div class="btn-wrap justify-content-center">
                                <a href="{{ route('user.ticket.close.now',$ticket->uuid) }}" class="site-btn danger-btn">
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
                                </a>
                                <button type="button" class="site-btn danger-btn disable" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="icon-close-circle"></i>{{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="reopenTicket" tabindex="-1" aria-labelledby="reopenTicketModalLabel" aria-hidden="true">
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
                            <h3>{{ __('Are you sure?') }}</h3>
                        </div>
                        <div class="bottom-content">
                            <p class="description">{{ __('You want to reopen this Ticket?') }}</p>
                            <div class="btn-wrap justify-content-center">
                                <a href="{{ route('user.ticket.show',['uuid' => $ticket->uuid,'action' => 'reopen']) }}" class="site-btn danger-btn">
                                    <span>
                                        <svg width="20" height="20"
                                                viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="10" cy="10" r="10" fill="white"
                                                    fill-opacity="0.2" />
                                                <path d="M14 7L8.5 12.5L6 10" stroke="white" stroke-width="1.8"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>{{ __('Reopen Now') }}
                                </a>
                                <button type="button" class="site-btn danger-btn disable" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="icon-close-circle"></i>{{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
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
@endsection
