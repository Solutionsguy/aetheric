    <!-- Banner section start -->
    <section class="banner-area banner-style-one p-relative fix">
        <div class="container">
            <div class="row gy-30 align-items-center">
                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                    <div class="banner-content p-relative">

                        <h1 class="banner-title">{{ $data['hero_title'] }}
                        </h1>

                        <p class="description">{{ $data['sub_title'] }}</p>

                        <div class="btn-wrap">
                            <a class="site-btn warning-btn btn-xs" href="{{ $data['hero_button_url'] }}"
                                target="{{ $data['hero_button_target'] }}">{{ $data['hero_button_level'] }} <i
                                    class="{{ $data['hero_button_icon'] }}"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-4">
                    <div class="banner-thumb-wrapper">
                        <span class="round-one"></span>
                        <span class="round-two"></span>
                        <span class="round-three"></span>
                        <div class="banner-thumb">
                            <img src="{{ asset($data['hero_right_img']) }}" alt="banner thumb">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-shapes d-none d-md-block">
            <div class="shape-one">
                <img src="assets/frontend/default/images/shapes/banner-one/shape-01.svg" alt="banner-shape">
            </div>
            <div class="shape-two">
                <img src="assets/frontend/default/images/shapes/banner-one/shape-02.svg" alt="banner-shape">
            </div>
            <div class="shape-three">
                <img src="assets/frontend/default/images/shapes/banner-one/shape-03.svg" alt="banner-shape">
            </div>
            <div class="shape-four">
                <img src="assets/frontend/default/images/shapes/banner-one/shape-04.svg" alt="banner-shape">
            </div>
            <div class="shape-five">
                <img src="assets/frontend/default/images/shapes/banner-one/shape-05.svg" alt="banner-shape">
            </div>
        </div>
    </section>
    <!-- Banner section end -->
