<!DOCTYPE html>
@php
    $isRtl = isRtl(app()->getLocale());
@endphp
<html lang="{{ app()->getLocale() }}" @if($isRtl) dir="rtl" @endif>
@include('frontend::include.__head')
<body @class([
    'dark-theme' => session()->has('site-color-mode') ? session()->get('site-color-mode') == 'dark' : setting('default_mode') == 'dark',
    'rtl_mode' => $isRtl,
    'dashboard-bg'
])>

<!--Notification-->
@include('frontend::include.__notify')

<!-- Page-wrapper Start-->
<div class="page-wrapper">
	<!-- Page Header Start-->
    @include('frontend::include.__user_header')
	<!-- Page Header Ends -->
	<!-- Page Body Start-->
	<div class="page-body-wrapper">
		<!-- Page Sidebar Start-->
        @include('frontend::include.__user_side_nav')
		<!-- Page Sidebar Ends-->
		<div class="page-body">
			<!-- Container-fluid starts-->
			<div class="container-fluid default-page">
				@yield('content')
			</div>
			<!-- Container-fluid Ends-->
		</div>
	</div>
	<!-- Page Body Ends-->
</div>
<!-- Page-wrapper end-->
@include('frontend::include.__script')
</body>
</html>


