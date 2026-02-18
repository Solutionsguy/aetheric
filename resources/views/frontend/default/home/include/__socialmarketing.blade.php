<!-- Social marketing section start -->
<section class="social-marketing-section section-space-top">
    <div class="container">
        <div class="row gy-50 align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="social-marketing-thumb">
                    <img src="{{ asset($data['right_img']) }}" alt="social marketin">
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="social-marketing-content">
                    <div class="section-title-wrapper">
                        <h2 class="section-title mb-30">{{ $data['title_small'] }}</h2>
                    </div>
                    <p class="description">{{ $data['content'] }}</p>
                    <div class="btn-inner">
                        <a class="site-btn primary-btn btn-xs" href="{{ $data['social_media_button_url'] }}" target="{{ $data['social_media_button_target'] }}">{{ $data['social_media_button_level'] }} <i class="{{ $data['social_media_button_icon'] }}"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Social marketing section end -->