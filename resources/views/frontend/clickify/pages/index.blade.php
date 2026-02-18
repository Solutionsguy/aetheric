@extends('frontend::layouts.app')
@section('content')

<!-- Breadcrumb area start -->
<section class="breadcrumb-area p-relative z-index-11 fix breadcrumb-overlay-two style-two position-relative">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6">
                <div class="breadcrumb-content-wrapper">
                    <div class="breadcrumb-content-two">
                        <h1 class="title">@yield('title')</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <div class="breadcrumb-shapes-two">
        <div class="shape-one">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/1.svg" alt="shape not found">
        </div>
        <div class="shape-two">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/2.svg" alt="shape not found">
        </div>
        <div class="shape-three">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/3.svg" alt="shape not found">
        </div>
        <div class="shape-four">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/4.svg" alt="shape not found">
        </div>
        <div class="shape-five">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/5.svg" alt="shape not found">
        </div>
        <div class="shape-six">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/6.svg" alt="shape not found">
        </div>
        <div class="shape-seven">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/breadcrumb-two/7.svg" alt="shape not found">
        </div>
    </div>
    <div class="breadcrumb-round-two">
        <div class="round-one"></div>
        <div class="round-two"></div>
        <div class="round-three"></div>
    </div>
</section>
<!-- Breadcrumb area end -->


@yield('page-content')

@endsection
