@php
$benefits =\App\Models\LandingContent::where('type','benefits')->where('locale',app()->getLocale())->get()->chunk(2);

@endphp

{{-- <!-- Benefits section start -->
<section class="benefits-section section-space p-relative fix benefits-overlay include-bg"
    data-background="{{ asset($data['bg_img']) }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="section-title-wrapper is-white text-center section-title-space">
                    <h2 class="section-title mb-20">{{ $data['title_small'] }}</h2>
                    <p class="b1 description max-w-640">{{ $data['title_big'] }}</p>
                </div>
            </div>
        </div>
        <div class="benefits-grid">
            @foreach($benefits as $benefitlists)
            <div class="column">
                @foreach($benefitlists as $benefitlist)
                <div class="benefits-item">
                    <div class="icon">
                        <span><img src="{{ asset($benefitlist->icon) }}" alt="benefits icon"></span>
                    </div>
                    <div class="content">
                        <h3 class="title">{{ $benefitlist->title }}</h3>
                        <p class="description">{{ $benefitlist->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
    <div class="benefits-shapes">
        <div class="shape-one">
            <img src="assets/frontend/default/images/shapes/petals.svg" alt="benefits-shapes">
        </div>
    </div>
</section>
<!-- Benefits section end --> --}}

<!-- Benefits section start -->
<section class="benefits-section-two fix section-space p-relative z-index-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-6 col-lg-6">
                <div class="section-title-wrapper is-white text-center section-title-space">
                    <h2 class="section-title mb-20">{{ $data['title_small'] }}</h2>
                    <p class="b1 description max-w-640">{{ $data['title_big'] }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-50">
            <div class="col-xxl-4 col-xl-4">
                <div class="benefits-thumb-wrap style-two">
                    <div class="benefits-thumb">
                        <img src="{{ asset($data['left_img']) }}" alt="benefits-thumb">
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-8">
                <div class="benefits-item-wrapper-two">
                    @foreach($benefits as $benefitlists)
                    <div class="column">
                        @foreach($benefitlists as $benefitlist)
                        <div class="benefits-item-two">
                            <div class="icon">
                                <span><img src="{{ asset($benefitlist->icon) }}" alt="benefits icon"></span>
                            </div>
                            <div class="content">
                                <h3 class="title">{{ $benefitlist->title }}</h3>
                                <p class="description">{{ $benefitlist->description }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="benefits-shapes-two">
        <div class="shape-one">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/benefits/spiral.svg" alt="benefits-shapes">
        </div>
        <div class="shape-two">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/benefits/shape-02.svg" alt="benefits-shapes">
        </div>
        <div class="shape-three">
            <img data-parallax='{"y": -120, "smoothness": 20}' src="{{ asset('/') }}/frontend/default/images/shapes/benefits/shape-03.svg"
                alt="benefits-shapes">
        </div>
    </div>
</section>
<!-- Benefits section end -->
