@php
    $footerContent = json_decode(
        \App\Models\LandingPage::where('locale', app()->getLocale())
            ->where('status', true)
            ->where('theme', site_theme())
            ->where('code', 'footer')
            ->first()?->data,
        true,
    );
@endphp


@if ($footerContent !== null)
    <!-- Footer area start -->
    <footer>
        <div class="footer-area footer-secondary fix position-relative z-index-11">
            <div class="container">
                <div class="footer-main">
                    <div class="row gy-50 justify-content-between">
                        @foreach ($navigations as $navigation)
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-4 col-sm-6">
                                <div class="footer-widget-1-1">
                                    <div class="footer-widget-title">
                                        <h5>{{ $footerContent['widget_title_' . $loop->iteration] ?? '' }}</h5>
                                    </div>
                                    <div class="footer-link">
                                        <ul>
                                            @foreach ($navigation as $menu)
                                                @if ($menu->page->status || $menu->page_id == null)
                                                    <li><a href="{{ url($menu->url) }}">{{ $menu->tname }}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-4">
                            <div class="footer-widget-1-3">
                                <div class="footer-widget-title">
                                    <h5>{{ $footerContent['widget_title_3'] }}</h5>
                                </div>
                                <div class="footer-info-two">
                                    <ul>
                                        <li>
                                            <div class="footer-info-item">
                                                <div class="footer-info-icon">
                                                    <span><i class="fa-solid fa-envelope"></i></span>
                                                </div>
                                                <div class="footer-info-text">
                                                    <span><a
                                                            href="mailto:{{ $footerContent['contact_email_address'] }}">{{ $footerContent['contact_email_address'] }}</a></span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="footer-info-item">
                                                <div class="footer-info-icon">

                                                    <span><i class="fa-solid fa-phone"></i></span>
                                                </div>
                                                <div class="footer-info-text">
                                                    <span><a
                                                            href="tel:{{ $footerContent['contact_phone_number'] }}">{{ $footerContent['contact_phone_number'] }}</a></span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="footer-info-item">
                                                <div class="footer-info-icon">
                                                    <span><i class="fab fa-telegram"></i></span>
                                                </div>
                                                <div class="footer-info-text">
                                                    <span><a
                                                            href="{{ $footerContent['contact_telegram_link'] }}">{{ $footerContent['contact_telegram_title'] }}</a></span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-6 col-sm-12">
                            <div class="footer-widget-1-4">
                                <div class="footer-newslatter">
                                    <div class="content">
                                        <h3 class="title">{{ $footerContent['community_title'] }}</h3>
                                        <p class="description">
                                            {{ $footerContent['community_description'] }}
                                        </p>

                                        <a class="site-btn warning-btn btn-xs"
                                            href="{{ $footerContent['footer_button_url'] }}"
                                            target="{{ $footerContent['footer_button_target'] }}">
                                            <i class="{{ $footerContent['footer_button_icon'] }}"></i>
                                            {{ $footerContent['footer_button_level'] }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="footer-copyright-two">
                            <div class="footer-copyright-left">
                                <div class="logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset(setting('site_logo', 'global')) }}" alt="logo">
                                    </a>
                                </div>
                                <p class="description">{{ $footerContent['copyright_text'] }}</p>
                            </div>
                            <div class="footer-copyright-right">
                                <div class="footer-social">
                                    @foreach (\App\Models\Social::all() as $social)
                                        <a href="{{ url($social->url) }}"><i
                                                class="{{ $social->class_name }}"></i></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-two-shapes">
                <div class="shape-one">
                    <img data-parallax='{"y": -80, "smoothness": 20}'
                        src="{{ asset('/') }}/frontend/default/images/shapes/footer-two/1.svg" alt="footer-shape">
                </div>
                <div class="shape-two">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/footer-two/2.svg" alt="footer-shape">
                </div>
                <div class="shape-three">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/footer-two/3.svg" alt="footer-shape">
                </div>
                <div class="shape-four">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/footer-two/4.svg" alt="footer-shape">
                </div>
                <div class="shape-five">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/footer-two/5.svg" alt="footer-shape">
                </div>
                <div class="shape-six">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/footer-two/6.svg" alt="footer-shape">
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer area end -->
@endif
