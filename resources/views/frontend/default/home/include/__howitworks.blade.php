@php
    $landingContent =\App\Models\LandingContent::where('type','howitworks')->where('locale',app()->getLocale())->get();
@endphp
<!-- How It Works section start -->
<section class="how-it-works-area p-relative z-index-11 section-space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-6 col-lg-6">
                <div class="section-title-wrapper text-center section-title-space">
                    <h2 class="section-title mb-20">{{ $data['title_small'] }}</h2>
                    <p class="b1">{{ $data['title_big'] }}</p>
                </div>
            </div>
        </div>
        <div class="how-it-works-grid">
            <div class="line-shapes">
                <img src="assets/frontend/default/images/shapes/dot-line.svg" alt="dot-line">
            </div>
            @foreach($landingContent as $content)
            <div class="how-it-works-item">
                <div class="thumb">
                    <img src="{{ asset($content->icon) }}" alt="work thumb">
                    <span class="number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="content">
                    <h3 class="title">{{ $content->title }}</h3>
                    <p class="description">{{ $content->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="how-it-shapes">
        <div class="shape-one d-none d-lg-block">
            <img src="assets/frontend/default/images/shapes/how-it-work/shape-01.svg" alt="how it shape">
        </div>
        <div class="shape-two">
            <img src="assets/frontend/default/images/shapes/how-it-work/shape-02.svg" alt="how it shape">
        </div>
        <div class="shape-three d-none d-lg-block   ">
            <img src="assets/frontend/default/images/shapes/how-it-work/shape-03.svg" alt="how it shape">
        </div>
    </div>
</section>
<!-- How It Works section end -->