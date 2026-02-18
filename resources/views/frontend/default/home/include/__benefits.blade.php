@php
    $benefits =\App\Models\LandingContent::where('type','benefits')->where('locale',app()->getLocale())->get()->chunk(2);

@endphp

<!-- Benefits section start -->
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
<!-- Benefits section end -->