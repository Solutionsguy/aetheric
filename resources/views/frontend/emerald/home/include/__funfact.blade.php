@php
    $landingContents =\App\Models\LandingContent::where('type','funfact')->where('locale',app()->getLocale())->get();
@endphp

<!-- fun fact section start -->
<section class="fun-fact-area section-space">
    <div class="container">
        <div class="row gy-50 align-items-center">
            <div class="col-xxl-6 col-xl-5 col-lg-6">
                <div class="fun-fact-content">
                    <div class="section-title-wrapper">
                        <h2 class="section-title mb-40">{{ $data['title_small'] }}</h2>
                        <p class="description">{{ $data['title_big'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-7 col-lg-6">
                <div class="fun-fact-counter-grid">
                    @foreach($landingContents as $content)
                    <div class="single-counter-item is-active">
                        <div class="icon">
                            <img src="{{ asset($content->icon) }}" alt="counter icon">
                        </div>
                        <div class="content">
                            <h3 class="title"><span class="odometer" data-count="{{ $content->description }}"></span></h3>
                            <p class="description">{{ $content->title }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- fun fact section end -->