@php
    $isRtl = isRtl(app()->getLocale());
@endphp

<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}" @if ($isRtl) dir="rtl" @endif>

@include('frontend::include.__head')

<body @class([
    'auth-body',
    'dark-theme' =>
        session()->get('site-color-mode', setting('default_mode')) == 'dark',
    'rtl_mode' => $isRtl,
])>

    <!-- Header area start -->
    <header>
        <div class="header-area header-primary header-auth header-transparent" id="header-sticky">
            <div class="header-inner">
                <div class="header-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset(setting('site_logo', 'global')) }}"
                            alt="Logo"></a>
                </div>
                <div class="header-right style-one">
                    <div class="auth-header-action">
                        <div class="header-lang-item header-lang">
                            <span class="header-lang-toggle" id="header-lang-toggle"><i class="fa-regular fa-globe"></i>
                                <span class="lang-text">{{ localeName() }}</span></span>
                            <ul id="language-list" class="hidden">
                                @foreach (\App\Models\Language::where('status', true)->get() as $lang)
                                    <li><a href="{{ route('language-update', ['name' => $lang->locale]) }}">{{ $lang->name }}
                                            <span class="icon"></span></a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="color-switcher">
                            <span class="light-icon">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9 1.5C8.00544 2.49456 7.4467 3.84348 7.4467 5.25C7.4467 6.65652 8.00544 8.00544 9 9C9.99457 9.99456 11.3435 10.5533 12.75 10.5533C14.1565 10.5533 15.5054 9.99456 16.5 9C16.5 10.4834 16.0601 11.9334 15.236 13.1668C14.4119 14.4001 13.2406 15.3614 11.8701 15.9291C10.4997 16.4968 8.99168 16.6453 7.53683 16.3559C6.08197 16.0665 4.7456 15.3522 3.6967 14.3033C2.64781 13.2544 1.9335 11.918 1.64411 10.4632C1.35472 9.00832 1.50325 7.50032 2.07091 6.12987C2.63856 4.75943 3.59986 3.58809 4.83323 2.76398C6.0666 1.93987 7.51664 1.5 9 1.5Z"
                                        stroke="#5C5958" stroke-width="1.3" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="dark-icon">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.0007 15.4168C12.9922 15.4168 15.4173 12.9917 15.4173 10.0002C15.4173 7.00862 12.9922 4.5835 10.0007 4.5835C7.00911 4.5835 4.58398 7.00862 4.58398 10.0002C4.58398 12.9917 7.00911 15.4168 10.0007 15.4168Z"
                                        stroke="#B4B5BA" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M15.9493 15.9498L15.841 15.8415M15.841 4.15817L15.9493 4.04984L15.841 4.15817ZM4.04935 15.9498L4.15768 15.8415L4.04935 15.9498ZM9.99935 1.73317V1.6665V1.73317ZM9.99935 18.3332V18.2665V18.3332ZM1.73268 9.99984H1.66602H1.73268ZM18.3327 9.99984H18.266H18.3327ZM4.15768 4.15817L4.04935 4.04984L4.15768 4.15817Z"
                                        stroke="#B4B5BA" stroke-width="1.66667" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header area end -->

    <!--Notification-->
    @include('frontend::include.__notify')

    <!-- Body main wrapper start -->
    <main>

        @yield('content')

    </main>
    <!-- Body main wrapper end -->

    <!-- Footer area start -->
    <footer>
        <div class="dashboard-footer-area">
            <div class="need-content">
                <p class="description"><a href="{{ url('contact') }}">{{ __('Need Help?') }}</a></p>
            </div>
        </div>
    </footer>
    <!-- Footer area end -->

    <!-- JS here -->
    @include('frontend::include.__script')

    <script>
        (function($) {
            'use strict';

            // password hide show
            let eyeicons = document.querySelectorAll('.eyeicon');
            let passwords = document.querySelectorAll('.password-input');

            eyeicons.forEach(function(eyeicon, index) {
                eyeicon.onclick = function() {
                    if (passwords[index].type === "password") {
                        passwords[index].type = "text";
                        eyeicon.src = '{{ asset('frontend/default/images/icons/eye.svg') }}';
                    } else {
                        passwords[index].type = "password";
                        eyeicon.src = '{{ asset('frontend/default/images/icons/eye-off.svg') }}';
                    }
                };
            });

        })(jQuery);
    </script>

</body>

</html>
