
<!-- Banner section start -->
<section class="banner-area banner-style-two p-relative z-index-11 fix">
<div class="container">
    <div class="row gy-50 align-items-center">
        <div class="col-xxl-6 col-xl-6 col-lg-7 col-md-6">
            <div class="banner-content style-two p-relative">
                <h1 class="banner-title">
                    {{ $data['hero_title'] }}
                </h1>
                <p class="description">{{ $data['sub_title'] }}</p>
                <div class="btn-wrap">
                    <a class="site-btn orange-btn hover-slide-righ left-right-radius btn-xs" href="{{ $data['hero_button_url'] }}" target="{{ $data['hero_button_target'] }}"><i
                            class="{{ $data['hero_button_icon'] }}"></i> {{ $data['hero_button_level'] }}</a>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6">
            <div class="banner-thumb-wrapper style-two">
            <div class="banner-thumb">
                <img src="{{ asset($data['hero_right_img']) }}" alt="banner thumb">
            </div>
            <div class="triangle-shapes">
                <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/triangle.svg" alt="triangle shapes">
            </div>
            </div>
        </div>
    </div>
</div>
<div class="banner-shapes d-none d-md-block">
    <div class="shape-one">
        <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/shape-one.svg" alt="banner-shape">
    </div>
    <div class="shape-two">
        <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/shape-two.svg" alt="banner-shape">
    </div>
    <div class="shape-three">
        <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/shape-three.svg" alt="banner-shape">
    </div>
    <div class="shape-four">
        <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/shape-four.svg" alt="banner-shape">
    </div>
    <div class="shape-five">
        <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/shape-five.svg" alt="banner-shape">
    </div>
    <div class="shape-six">
        <img src="{{ asset("/") }}/frontend/default/images/shapes/banner-two/shape-six.svg" alt="banner-shape">
    </div>
</div>
</section>
<!-- Banner section end -->