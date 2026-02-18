@php
    $footerContent = json_decode(\App\Models\LandingPage::where('locale',app()->getLocale())->where('status',true)->where('theme',site_theme())->where('code','footer')->first()?->data,true);
@endphp

@if($footerContent !== null)
    <!-- Footer area start -->
    <footer>
        <div class="footer-area footer-primary fix position-relative z-index-1">

            <div class="container">
                <div class="footer-main">
                    <div class="row gy-50">
                        <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6">
                            <div class="footer-widget-1-1">
                                <div class="footer-logo">
                                    <a href="{{route('home')}}">
                                        <img src="{{ asset(setting('site_logo','global')) }}" alt="logo not found">
                                    </a>
                                </div>
                                <div class="footer-content">
                                    <p class="description">{{ $footerContent['widget_left_description'] }}</p>
                                </div>
                            </div>
                        </div>

                        @foreach($navigations as $navigation)
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6">
                                <div class="footer-widget">
                                    <div class="footer-widget-title">
                                        <h5>{{ $footerContent['widget_title_'.$loop->iteration] ?? '' }}</h5>
                                    </div>
                                    <div class="footer-link">
                                        <ul>
                                            @foreach($navigation as $menu)
                                                @if($menu->page->status|| $menu->page_id == null)
                                                    <li><a href="{{ url($menu->url) }}">{{ $menu->tname }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="footer-widget justify-content-lg-end">
                                <div class="footer-widget-title">
                                    <h5>{{ $footerContent['widget_title_3'] }}</h5>
                                </div>
                                <div class="footer-contact">
                                    <div class="footer-info">
                                        <div class="footer-info-item">
                                            <div class="footer-info-icon">
                                                <span><i class="fa-solid fa-envelope"></i></span>
                                            </div>
                                            <div class="footer-info-text">
                                                <span><a href="mailto:{{ $footerContent['contact_email_address'] }}">{{ $footerContent['contact_email_address'] }}</a></span>
                                            </div>
                                        </div>
                                        <div class="footer-info-item">
                                            <div class="footer-info-icon">
                                                <span><i class="fa-solid fa-phone"></i></span>
                                            </div>
                                            <div class="footer-info-text">
                                                <span><a href="tel:510652-7401">{{ $footerContent['contact_phone_number'] }}</a></span>
                                            </div>
                                        </div>
                                        <div class="footer-info-item">
                                            <div class="footer-info-icon">
                                                <span><i class="fab fa-telegram"></i></span>
                                            </div>
                                            <div class="footer-info-text">
                                                <span><a href="{{ $footerContent['contact_telegram_link'] }}" target="_blank">{{ $footerContent['contact_telegram_title'] }}</a></span>
                                            </div>
                                        </div>
                                        <div class="footer-social">
                                            @foreach(\App\Models\Social::all() as $social)
                                                <a href="{{ url($social->url) }}"><i class="{{ $social->class_name }}"></i></a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="footer-bottom">
                            <div class="footer-copyright text-center">
                                <p class="p1">{{ $footerContent['copyright_text'] }}<a href="{{route('home')}}"> </a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-shapes">
                <div class="shape-one">
                    <img src="{{ asset('/frontend/default/images/shapes/footer/footer-shapes-01.svg') }}" alt="footer-shape">
                </div>
                <div class="shape-two">
                    <img src="{{ asset('/frontend/default/images/shapes/footer/footer-shapes-02.svg') }}" alt="footer-shape">
                </div>
                <div class="shape-three">
                    <img src="{{ asset('/frontend/default/images/shapes/footer/footer-shapes-03.svg') }}" alt="footer-shape">
                </div>
                <div class="shape-four">
                    <img src="{{ asset('/frontend/default/images/shapes/footer/footer-shapes-04.svg') }}" alt="footer-shape">
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer area end -->
@endif