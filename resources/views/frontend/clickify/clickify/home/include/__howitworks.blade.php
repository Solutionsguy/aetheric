@php
$landingContent =\App\Models\LandingContent::where('type','howitworks')->where('locale',app()->getLocale())->get();
@endphp

<!-- System work section start -->
<div class="system-work-section p-relative z-11 section-space">
    <div class="container">
        <div class="row section-title-space">
            <div class="col-xxl-5 col-lg-6">
                <div class="section-title-wrapper">
                    <h2 class="section-title mb-20">{{ $data['title'] }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12">
                @foreach($landingContent as $content)
                <div class="system-work-item">
                    <div class="system-work-tumb">
                        <img src="{{ asset($content->icon) }}" alt="system-work">
                    </div>
                    <div class="system-work-content-wrap">
                        <div class="number">
                            <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="content">
                            <h3 class="title">{{ $content->title }}</h3>
                            <p class="description">{{ $content->description }}</p>
                        </div>
                    </div>
                    <div class="shape-arrow">
                        <span>
                            @if($loop->odd)
                            <svg width="904" height="480" viewBox="0 0 904 480" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M50.3057 451.001L49.0059 469.206L62.2451 469.497" stroke="#F7AFAC"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M865.112 31.1245C843.116 112.199 755.036 210.999 473.807 194.977C388.771 184.498 133.375 260.14 51.5361 467.499"
                                    stroke="#F34141" stroke-opacity="0.6" stroke-width="3.5" stroke-dasharray="5 5" />
                            </svg>
                            @elseif($loop->even)
                            <div class="shape-arrow">
                                <span>
                                   <svg width="909" height="463" viewBox="0 0 909 463" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M860.195 433.265L861.887 451.437L848.657 452.014" stroke="#F7AFAC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                      <path d="M36.5174 31.0688C60.2585 111.65 150.449 208.526 431.267 186.44C516.058 174.128 773.026 244.242 859.32 449.786" stroke="#F34141" stroke-opacity="0.6" stroke-width="3.5" stroke-dasharray="5 5"></path>
                                   </svg>
                                </span>
                             </div>
                            @endif
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="system-work-shapes">
        <div class="shape-one">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/system-work/spiral.svg" alt="spiral">
        </div>
        <div class="shape-two">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/system-work/blob.svg" alt="blob">
        </div>
        <div class="shape-three">
            <img src="{{ asset('/') }}/frontend/default/images/shapes/system-work/transparency.svg" alt="transparency">
        </div>
    </div>
</div>
<!-- System work section end -->
