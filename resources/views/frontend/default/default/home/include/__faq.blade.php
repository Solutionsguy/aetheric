@php
    $faqs =\App\Models\LandingContent::where('type','faq')->where('locale',app()->getLocale())->get();
@endphp
<!-- FAQ section start -->
<section class="faq-area style-one section-space">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="accordion-wrapper site-faq">
                    <div class="accordion" id="accordionExampleThree">
                    @foreach($faqs as $index => $faq) <!-- Add index to loop -->
                        <div class="accordion-item">
                            <h6 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    <span>{{ sprintf('%02d', $index + 1) }}:</span>{{ $faq->title }} <!-- Dynamic numbering -->
                                </button>
                            </h6>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}"
                                 data-bs-parent="#accordionExampleThree">
                                <div class="accordion-body">
                                    <p>{{ $faq->description }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="faq-content">
                    <div class="faq-support">
                        <div class="thumb">
                            <img src="{{ asset($data['left_img']) }}" alt="faq-support">
                        </div>
                        <div class="section-title-wrapper">
                            <h2 class="section-title mb-30">{{ $data['title_small'] }}</h2>
                        </div>
                        <p class="description">{{ $data['title_big'] }}</p>
                        <div class="btn-inner">
                            <a class="site-btn warning-btn btn-xs" href="{{ $data['faq_button_url'] }}" target="{{ $data['faq_button_target'] }}">{{ $data['faq_button_level'] }} <i
                                        class="{{ $data['faq_button_icon'] }}"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FAQ section end -->
