<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('site_title', 'global') }} - @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon"/>

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('frontend/default/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/fontawesome-pro.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/odometer-default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/iconsax.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/spacing.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/default/css/styles.css?v=1.2')}}">

    @stack('style')
</head>
