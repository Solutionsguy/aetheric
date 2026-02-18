@php
$landingContents =\App\Models\LandingContent::where('type','funfact')->where('locale',app()->getLocale())->get();
@endphp
<!-- Earning money section start -->
<section class="earning-money-section section-space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="section-title-wrapper text-center section-title-space">
                    <h2 class="section-title mb-20">{{ $data['title'] }}</h2>
                </div>
            </div>
        </div>
        <div class="earning-counter-wrap">
            <div class="row">
                @foreach($landingContents as $content)
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="earning-counter-item">
                        <div class="icon">
                            <img src="{{ asset($content->icon) }}" alt="counter icon">
                        </div>
                        <div class="content">
                            <h3 class="title"><span class="odometer" data-count="{{ $content->description }}">00</span></h3>
                            <p class="description">{{ $content->title }}</p>
                        </div>
                        <div class="shape">
                            <img src="{{ asset('/') }}/frontend/default/images/shapes/earning-money/01.svg" alt="earning-money shapes">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Earning money section end -->
