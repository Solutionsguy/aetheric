
<h3 class="title">{{ __('Details') }}</h3>
<div class="modal-list-content">
    <div class="heading">
        <h5>{{ $kyc->kyc?->name ?? $kyc->type }}</h5>
    </div>
    <div class="modal-list-info">
        <ul>
            <li class="list-item">
                {{ __('Status') }} :
                @if($kyc->status == 'pending')
                <div class="type site-badge badge-primary">{{ ucfirst($kyc->status) }}</div>
                @elseif($kyc->status == 'rejected')
                <div class="type site-badge badge-failed">{{ ucfirst($kyc->status) }}</div>
                @elseif($kyc->status == 'approved')
                <div class="type site-badge badge-success">{{ ucfirst($kyc->status) }}</div>
                @endif
            </li>
            @if($kyc->status != 'pending')
            <div class="list-item">{{ __('Message From Admin') }} : <div
                    class="type site-badge badge-primary">{{ $kyc->message }}</div>
            </div>
            @endif
            @foreach ($kyc->data as $key => $value)
            <li class="list-item">{{ $key }} :
                @if(file_exists(base_path('assets/'.$value))) <br>
                <a href="{{ asset($value) }}" target="_blank" data-bs-toggle="tooltip"
                    title="Click here to view document">
                    <img src="{{ asset($value) }}" alt="" />
                </a>
                @else
                <strong>{{ $value }}</strong>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>

