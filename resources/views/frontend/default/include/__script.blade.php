<script src="{{ asset('frontend/default/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/jquery.appear.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/odometer.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/swiper.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/meanmenu.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/landing.js') }}"></script>
<script src="{{ asset('global/js/lucide.min.js') }}"></script>
<script src="{{ asset('frontend/default/js/sidebar.js') }}"></script>
<script src="{{ asset('frontend/default/js/main.js') }}"></script>
<script src="{{ asset('global/js/custom.js') }}"></script>

<script>
    "use strict";

    // Color Switcher
    $(".color-switcher").on('click', function () {
        $("body").toggleClass("dark-theme");
        var url = '{{ route("mode-theme") }}';
        $.get(url);
    });
</script>

@include('global.__t_notify')
@if(auth()->check())
    <script src="{{ asset('global/js/pusher.min.js') }}"></script>
    @include('global.__notification_script',['for'=>'user','userId' => auth()->user()->id])
@endif

@stack('js')
@php
    $googleAnalytics = plugin_active('Google Analytics');
    $tawkChat = plugin_active('Tawk Chat');
    $fb = plugin_active('Facebook Messenger');
@endphp

@if($googleAnalytics)
    @include('frontend::plugin.google_analytics',['GoogleAnalyticsId' => json_decode($googleAnalytics?->data,true)['app_id']])
@endif
@if($tawkChat)
    @include('frontend::plugin.tawk',['data' => json_decode($tawkChat->data, true)])
@endif
@if($fb)
    @include('frontend::plugin.fb',['data' => json_decode($fb->data, true)])
@endif

