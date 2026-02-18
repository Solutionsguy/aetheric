@extends('frontend::layouts.app')
@section('content')
    <!-- Breadcrumb area start -->
    <section class="breadcrumb-area fix breadcrumb-overlay style-one position-relative"
             data-background="{{ asset('/frontend/default/images/breadcrumb/breadcrumb-01.jpg') }} ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-xl-8">
                    <div class="breadcrumb-content-wrapper">
                        <div class="breadcrumb-content">
                            <h1 class="title">@yield('title')</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-round">
            <div class="round-one"></div>
            <div class="round-two"></div>
            <div class="round-three"></div>
        </div>
        <div class="breadcrumb-shapes">
            <div class="shape-one">
                <img src="{{ asset('/frontend/default/images/shapes/breadcrumb/1.svg') }}" alt="shape not found">
            </div>
            <div class="shape-two">
                <img src="{{ asset('/frontend/default/images/shapes/breadcrumb/2.svg') }}" alt="shape not found">
            </div>
            <div class="shape-three">
                <img src="{{ asset('/frontend/default/images/shapes/breadcrumb/3.svg') }}" alt="shape not found">
            </div>
            <div class="shape-four">
                <img src="{{ asset('/frontend/default/images/shapes/breadcrumb/4.svg') }}" alt="shape not found">
            </div>
        </div>
    </section>
    <!-- Breadcrumb area end -->

    @yield('page-content')

@endsection
