<!-- Refer friends section start -->
<div class="refer-friends-section x-clip p-relative z-index-11 section-space">
    <div class="container">
        <div class="row gy-50">
            <div class="col-xxl-5 col-xl-5 col-lg-6">
                <div class="refer-friends-content">
                    <div class="section-title-wrapper is-white mb-30">
                        <h2 class="section-title mb-30">{{ $data['title'] }}</h2>
                        <p class="b2 description">{{ $data['description'] }}</p>
                    </div>
                    <div class="btn-inner">
                        <a class="site-btn warning-btn left-right-radius btn-xs" href="{{ $data['invite_button_url'] }}" target="{{ $data['invite_button_target'] }}">
                            {{ $data['invite_button_level'] }}
                            <i class="{{ $data['invite_button_icon'] }}"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-7 col-xl-7 col-lg-6">
                <div class="refer-friends-thumb-wrap">
                    <div class="refer-friends-thumb">
                        <img src="{{ asset($data['right_img']) }}" alt="refer-friends">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="refer-friends-shapes">
        <div class="shape-one">
            <img data-parallax='{"y": 60, "smoothness": 20}' src="{{ asset('/') }}/frontend/default/images/shapes/refer-friends/spiral.svg"
                alt="spiral">
        </div>
        <div class="shape-two">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/refer-friends/rainbow.svg" alt="spiral">
        </div>
    </div>
</div>
<!-- Refer friends section end -->
