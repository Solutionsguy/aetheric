<!-- Invite section start -->
<section class="invite-section">
    <div class="container">
        <div class="row gy-30 align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="invite-thumb-wrap">
                    <div class="thumb-inner">
                        <div class="thumb">
                            <img src="{{ asset($data['invite_left_img']) }}" alt="invite thumb">
                        </div>
                        <div class="thumb">
                            <img src="{{ asset($data['invite_right_img']) }}" alt="invite thumb">
                        </div>
                    </div>
                    <div class="earn-card">
                        <p>{{ $data['left_bottom_text'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="invite-content">
                    <h2 class="section-title mb-30">{{ $data['title_small'] }}</h2>
                    <p class="b2">{{ $data['title_big'] }}
                    </p>
                    <div class="btn-inner">
                        <a class="site-btn primary-btn btn-xs" href="{{ $data['invite_button_url'] }}" target="{{ $data['invite_button_target'] }}">{{ $data['invite_button_level'] }} <i class="{{ $data['invite_button_icon'] }}"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Invite section end -->