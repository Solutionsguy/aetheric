
<!-- Social marketing section start -->
<section class="social-marketing-section social-overlay fix section-space">
    <div class="container">
        <div class="row gy-50 align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="social-marketing-wrap style-two">
                    <div class="social-marketing-thumb">
                        <img src="{{ asset($data['left_img']) }}" alt="social marketing">
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="social-marketing-content-two">
                    <div class="section-title-wrapper mb-30">
                        <h2 class="section-title mb-30">{{ $data['title_small'] }}</h2>
                    </div>
                    <div class="btn-inner">
                        <a class="site-btn orange-btn hover-slide-righ left-right-radius btn-xs" href="{{ $data['social_media_button_url'] }}"
                            target="{{ $data['social_media_button_target'] }}">
                            <i class="{{ $data['social_media_button_icon'] }}"></i> 
                            {{ $data['social_media_button_level'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social-marketing-shapes">
        <div class="shape-one">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/social-marketing/shapes-01.svg" alt="social-marketing shapes">
        </div>
        <div class="shape-two">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/social-marketing/shapes-02.svg" alt="social-marketing shapes">
        </div>
    </div>
</section>
<!-- Social marketing section end -->
