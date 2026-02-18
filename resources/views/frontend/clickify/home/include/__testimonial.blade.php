<?php
    $testimonials = App\Models\Testimonial::all();
    $locale = app()->getLocale();
?>

<!-- Trusted user section start -->
<section class="trusted-user-section section-space-bottom">
    <div class="container">
        <div class="row gy-50">
            <div class="col-xxl-6 col-xl-5 col-lg-5">
                <div class="trusted-user-content">
                    <div class="section-title-wrapper mb-30">
                        <h2 class="section-title mb-30">{{ $data['title'] }}</h2>
                        <p class="b3 description">
                            {{ $data['description'] }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-7 col-lg-7">
                <div class="trusted-slider-content-wrap">
                    <div class="swiper trusted-slider-active">
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                            @php
                                $name = data_get($testimonial->locale,$locale.'.'.'name',$testimonial->name);
                                $message = data_get($testimonial->locale,$locale.'.'.'message',$testimonial->message);
                                $designation = data_get($testimonial->locale,$locale.'.'.'designation',$testimonial->designation);
                            @endphp
                            <div class="swiper-slide">
                                <div class="trusted-slider-content">
                                    <p class="description">
                                        {{ $message }}
                                    </p>
                                    <div class="admin-item">
                                        <div class="admin-thumb">
                                            <img src="{{ asset($testimonial->picture) }}" alt="admin user">
                                        </div>
                                        <div class="admin-info">
                                            <h3 class="admin-title">{{ $name }}</h3>
                                            <span class="admin-des">{{ $designation }}</span>
                                        </div>
                                    </div>
                                    <div class="quote-shape">
                                        <img src="{{ asset('/') }}/frontend/default/images/icons/quote-two.svg" alt="quote-two">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- If we need navigation buttons -->
                    <div class="trusted-slider-navigation">
                        <button class="trusted-slider-btn trusted-slider-prev">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 17L6 12L11 7" stroke="#FC5D19" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M18 17L13 12L18 7" stroke="#FC5D19" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="trusted-slider-btn trusted-slider-next">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 17L18 12L13 7" stroke="#FC5D19" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M6 17L11 12L6 7" stroke="#FC5D19" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Trusted user section end -->
