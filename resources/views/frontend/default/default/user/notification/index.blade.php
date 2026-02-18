@extends('frontend::layouts.user')
@section('title')
{{ __('All Notifications') }}
@endsection
@section('content')
<div class="notifications-area">
    <div class="row gy-30">
        <div class="col-xxl-12">
            <div class="site-card">
                <div class="site-card-header">
                    <div class="site-title-inner">
                        <h3 class="site-card-title mb-0">{{ __('All Notifications') }}</h3>
                    </div>
                </div>
                <div class="notifications-item-wrapper">
                    @forelse($notifications as $notification)
                    <div class="notifications-item">
                        <div class="notification-list">
                            <div class="icon">
                                <i data-lucide="{{ $notification->icon }}"></i>
                            </div>
                            <div class="content">
                                <h4 class="title">{{ $notification->title }}</h4>
                                <div class="meta">
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="notifications-right-content">
                            @if(!$notification->read)
                            <div class="notifications-status">
                                <span class="status-icon"></span>
                            </div>
                            @endif
                            <div class="notifications-link">
                                <a class="site-btn" href="{{ route('user.read-notification', $notification->id) }}"> <i class="icon-arrow-right-2"></i> {{ __('Explore') }}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center">{{ __('No Notification Found!') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
