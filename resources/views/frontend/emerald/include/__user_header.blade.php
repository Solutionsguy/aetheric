
<div class="page-header">
    <div class="dashboard-header">
        <button class="toggle-sidebar"> <span class="bar-icon">
            <span></span> <span></span><span></span> </span>
        </button>
        <div class="header-right-content">
            @php
                $userId = auth()->id();
                $notifications = App\Models\Notification::with('user')->where('for','user')->where('user_id', $userId)->latest()->take(10)->get();
                $totalUnread = App\Models\Notification::with('user')->where('for','user')->where('user_id', $userId)->where('read', 0)->count();
                $totalCount = App\Models\Notification::with('user')->where('for','user')->where('user_id', $userId)->get()->count();
            @endphp
            <div class="user-action">
                <ul>
                    
                    <li>
                        <button class="notification-box" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false"> <span class="icon"><i class="icon-notification"></i></span> <span class="number-badge">{{ $totalUnread }}</span> </button>
                        <div class="dropdown-menu dropdown-menu-end notification-popup">
                            <div class="header-notifications">
                                <h3 class="title">{{ __('Notifications') }} ({{ $totalUnread }})</h3>
                                <div class="notifications-item-wrapper">
                                    @foreach ($notifications as $notification)
                                    <a href="{{ route($notification->for.'.read-notification', $notification->id) }}" class="notifications-item">
                                        <div class="notification-list">
                                            <div class="icon"> 
                                                <i data-lucide="{{ $notification->icon }}"></i>
                                            </div>
                                            <div class="content">
                                                <h4 class="title">{{ $notification->title }}</h4>
                                                <div class="meta"> <span>{{ $notification->created_at->diffForHumans() }}</span> </div>
                                            </div>
                                        </div>
                                        @if(!$notification->read)
                                        <div class="notifications-right-content">
                                            <div class="notifications-status"> <span class="status-icon"></span> </div>
                                        </div>
                                        @endif
                                    </a>
                                    @endforeach
                                </div>
                                <div class="btn-wrap"> 
                                    <a class="site-btn primary-btn btn-xxs border-radius-6" href="{{ route('user.notification.all') }}">
                                        <i class="icon-arrow-right-2"></i> {{ __('See All') }}
                                    </a>
                                    <a class="site-btn danger-btn disable btn-xxs border-radius-6" href="{{ route('user.read-notification', 0) }}">
                                        <span>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="10" cy="10" r="10" fill="#F34141" fill-opacity="0.1" />
                                                    <path d="M14 7L8.5 12.5L6 10" stroke="#F34141" stroke-width="1.8" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </span> 
                                        {{ __('Mark as All Read') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    @if(setting('language_switcher'))
                    <li>
                        <div class="language-box">
                            <div class="header-lang-item header-lang"> 
                                <span class="header-lang-toggle" id="header-lang-toggle">
                                    <i class="fa-regular fa-globe"></i>
                                    {{ localeName() }}
                                </span>
                                <ul>
                                    @foreach(\App\Models\Language::where('status',true)->get() as $lang)
                                    <li> <a href="{{ route('language-update',['name'=> $lang->locale]) }}">{{ $lang->name }}</a> </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="notification-box">
                            <div class="color-switcher"> 
                                <span class="light-icon">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                        d="M9 1.5C8.00544 2.49456 7.4467 3.84348 7.4467 5.25C7.4467 6.65652 8.00544 8.00544 9 9C9.99457 9.99456 11.3435 10.5533 12.75 10.5533C14.1565 10.5533 15.5054 9.99456 16.5 9C16.5 10.4834 16.0601 11.9334 15.236 13.1668C14.4119 14.4001 13.2406 15.3614 11.8701 15.9291C10.4997 16.4968 8.99168 16.6453 7.53683 16.3559C6.08197 16.0665 4.7456 15.3522 3.6967 14.3033C2.64781 13.2544 1.9335 11.918 1.64411 10.4632C1.35472 9.00832 1.50325 7.50032 2.07091 6.12987C2.63856 4.75943 3.59986 3.58809 4.83323 2.76398C6.0666 1.93987 7.51664 1.5 9 1.5Z"
                                        stroke="#5C5958" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> 
                                <span class="dark-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                    d="M10.0007 15.4168C12.9922 15.4168 15.4173 12.9917 15.4173 10.0002C15.4173 7.00862 12.9922 4.5835 10.0007 4.5835C7.00911 4.5835 4.58398 7.00862 4.58398 10.0002C4.58398 12.9917 7.00911 15.4168 10.0007 15.4168Z"
                                    stroke="#B4B5BA" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                    d="M15.9493 15.9498L15.841 15.8415M15.841 4.15817L15.9493 4.04984L15.841 4.15817ZM4.04935 15.9498L4.15768 15.8415L4.04935 15.9498ZM9.99935 1.73317V1.6665V1.73317ZM9.99935 18.3332V18.2665V18.3332ZM1.73268 9.99984H1.66602H1.73268ZM18.3327 9.99984H18.266H18.3327ZM4.15768 4.15817L4.04935 4.04984L4.15768 4.15817Z"
                                    stroke="#B4B5BA" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                </span> 
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="user-profile">
                <div class="user-profile-drop">
                    <div class="dropdown">
                        <button class="user-head-drop-btn dropdown-toggle" data-bs-auto-close="outside" type="button" data-bs-toggle="dropdown" aria-expanded="false"> 
                            <img src="{{ auth()->user()->avatar_path }}" alt="{{ auth()->user()->full_name }}">
                        </button>
                        <div class="dropdown-menu">
                            <div class="user-profile-info">
                                <div class="thumb"> 
                                    @if(auth()->user()->avatar != null && file_exists(base_path('assets/'.auth()->user()->avatar)))
                                    <img src="{{ asset(auth()->user()->avatar) }}" alt="">
                                    @else
                                    <img src="{{ asset('frontend/images/user.jpg') }}" alt="{{ auth()->user()->full_name }}">
                                    @endif
                                </div>
                                <div class="content">
                                    <h4 class="title">{{ auth()->user()->full_name }}</h4>
                                </div>
                            </div>
                            <div class="info-list">
                                <ul>
                                    <li>
                                        <div class="content">
                                            <div class="icon"> <i class="icon-profile-circle"></i> </div>
                                            <div class="info"> <a href="{{ route('user.setting.show') }}">{{ __('Profile Settings') }}</a> </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="content">
                                            <div class="icon"> <i class="icon-lock"></i> </div>
                                            <div class="info"> <a href="{{ route('user.change.password') }}">{{ __('Change Password') }}</a> </div>
                                        </div>
                                    </li>
                                    @if(setting('kyc_verification','permission'))
                                    <li>
                                        <div class="content">
                                            <div class="icon"> <i class="icon-shield-tick"></i> </div>
                                            <div class="info"> 
                                                <a href="{{ route('user.kyc') }}">
                                                    {{ __('ID Verification') }}
                                                </a> 
                                            </div>
                                            <p class="verification-status">
                                                {{ match(auth()->user()->kyc){
                                                    0 => __('Not Submitted'),
                                                    1 => __('Verified'),
                                                    2 => __('Pending'),
                                                    3 => __('Rejected')
                                                 } }}
                                            </p>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="user-logout"> 
                                <button type="submit" class="dropdown-item" form="logout-form"><i class="fas fa-arrow-right mt-1"></i><span>{{ __('Logout') }}</span></button> 
                            </div>

                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>