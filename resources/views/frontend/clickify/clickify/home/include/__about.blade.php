<!-- About section Start -->
<section class="about-area fix section-space p-relative z-index-11">
    <div class="container">
        <div class="row gy-50 align-items-center">
            <div class="col-xxl-7 col-xl-6 col-lg-6">
                <div class="about-thumb-wrap style-two">
                    <div class="about-thumb-one">
                        <img src="{{ asset($data['left_img']) }}" alt="about thumb">
                    </div>
                    <div class="shape-one"></div>
                </div>
            </div>
            <div class="col-xxl-5 col-xl-6 col-lg-6">
                <div class="about-content style-one">
                    <div class="section-title-wrapper mb-30">
                        <h2 class="section-title">{{ $data['title_small'] }}</h2>
                    </div>
                    <p class="b1 description mb-30">
                        {!! $data['content'] !!}
                    </p>
                    <div class="btn-inner">
                        <a class="site-btn blue-btn hover-slide-righ left-right-radius btn-xs" href="{{ $data['about_us_button_url'] }}">{{ $data['about_us_button_level'] }} 
                            <i class="{{ $data['about_us_button_icon'] }}"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-shapes-two">
        <div class="shape-one">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/about-two/shape-01.svg" alt="about shape">
        </div>
        <div class="shape-two">
            <img data-parallax='{"y": -120, "smoothness": 20}' src="{{ asset('/') }}/frontend/default/images/shapes/about-two/shape-02.svg"
                alt="about shape">
        </div>
    </div>
</section>
<!-- About section end -->
