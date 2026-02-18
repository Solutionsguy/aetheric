@php
$faqs =\App\Models\LandingContent::where('type','faq')->where('locale',app()->getLocale())->get();
@endphp
<!-- FAQ section start -->
<section class="faq-section-two section-space">
    <div class="container">
        <div class="row gy-50 align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="faq-content-two">
                    <div class="section-title-wrapper">
                        <h2 class="section-title section-title-space">{{ $data['title'] }}</h2>
                    </div>
                    <div class="accordion-wrapper site-faq">
                        <div class="accordion" id="faq">
                            @foreach($faqs as $index => $faq)
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="heading{{ $loop->iteration }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="false"
                                        aria-controls="collapse{{ $loop->iteration }}">
                                        {{ $faq->title }}
                                    </button>
                                </h6>
                                <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $loop->iteration }}" data-bs-parent="#faq">
                                    <div class="accordion-body">
                                        <p>
                                            {{ $faq->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="faq-thumb-wrap">
                    <div class="faq-thumb">
                        <img src="{{ asset($data['right_img']) }}" alt="faq-thumb">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ section end -->
