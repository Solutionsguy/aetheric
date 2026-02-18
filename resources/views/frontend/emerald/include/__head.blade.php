<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('site_title', 'global') }} - @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset(setting('site_favicon','global')) }}" type="image/x-icon"/>

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/fontawesome-pro.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/odometer-default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/swiper.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/iconsax.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/spacing.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/styles.css?v=1.2')}}">
    <link rel="stylesheet" href="{{ asset('frontend/'.site_theme().'/css/dark-theme.css')}}">

    @stack('style')
</head>
