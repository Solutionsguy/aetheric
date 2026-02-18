@php
    $landingContents =\App\Models\LandingContent::where('type','about')->where('locale',app()->getLocale())->get();
@endphp

<!-- About section Start -->
<section class="about-area section-space p-relative z-index-11">
    <div class="container">
        <div class="row gy-50 align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="about-thumb-wrap style-one">
                    <div class="about-thumb">
                        <img src="{{ asset($data['right_img']) }}" alt="about thumb">
                    </div>
                    <div class="card-one">
                        <p>{{ $data['left_top_text'] }}</p>
                    </div>
                    <div class="card-two">
                    </div>
                    <div class="establish-shape">
                        <h3>{{ $data['left_bottom_text'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="about-content style-one">
                    <div class="section-title-wrapper mb-25">
                        <h2 class="section-title">{{ $data['title_small'] }}</h2>
                    </div>
                    <p class="b1 description mb-20">{!! $data['content'] !!}</p>
                    <div class="about-info mb-25">
                        <div class="about-info-list">
                            <ul class="icon-list">
                                @foreach($landingContents as $landingContent)
                                <li>
                                 <span class="list-item_icon">
                                    <i class="{{ $landingContent->icon }}"></i>
                                 </span>
                                    <span class="list-item-text">{{ $landingContent->title }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="btn-inner">
                        <a class="site-btn primary-btn btn-xs" href="{{ $data['about_us_button_url'] }}">{{ $data['about_us_button_level'] }} <i class="{{ $data['about_us_button_icon'] }}"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-shapes">
        <div class="shape-one d-none d-lg-block">
            <img src="{{ asset('/frontend/default/images/shapes/about-one/shapes-01.svg') }}" alt="about shape">
        </div>
        <div class="shape-two">
            <img src="{{ asset('/frontend/default/images/shapes/about-one/shapes-02.svg') }}" alt="about shape">
        </div>
    </div>
</section>
<!-- About section end -->