@if(session('notify'))
@php
$notification = session('notify');
$icon = $notification['type'] == 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation';
@endphp
<!-- Notify start -->
<div class="notify-box {{ $notification['type'] == 'success' ? 'success' : 'error' }}">
    <div class="notify-contents">
        <div class="notify-icon">
            <span><i class="fa-solid {{ $icon }}"></i></span>
        </div>
        <div class="notify-content">
            <h4 class="notify-title">{{ ucfirst($notification['title']) }}</h4>
            <p class="notify-description">{{ $notification['message'] }}</p>
        </div>
        <div class="notify-close">
            <button id="notifyCloseBtn"><i class="fa-light fa-xmark"></i></button>
        </div>
    </div>
</div>
<!-- Notify end -->
@endif
