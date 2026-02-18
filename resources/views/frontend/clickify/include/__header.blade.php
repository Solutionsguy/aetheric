<!-- Header area start -->
<header>
    <!-- header section start -->
    <div class="header-area header-transparent header-style-two" id="header-sticky">
        <div class="container">
            <div class="header-inner">
                <div class="header-logo">
                    <a class="logo-white" href="{{ route('home') }}"><img src="{{ asset(setting('site_logo','global')) }}"
                            alt="Logo not found"></a>
                    <a class="logo-black" href="{{ route('home') }}"><img src="{{ asset(setting('site_logo','global')) }}"
                            alt="Logo not found"></a>
                </div>
                <div class="header-right">
                    <div class="header-menu d-none d-xl-inline-flex">
                        <nav class="td-main-menu main-menu-two" id="mobile-menu">
                            <ul>
                                @foreach($navigations as $navigation)
                                @if($navigation->page->status|| $navigation->page_id == null)
                                <li>
                                    <a href="{{ url($navigation->url) }}"  @class([
                                        'active' => url()->current() == url($navigation->url)
                                    ])>{{ $navigation->tname }}</a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                    <div class="header-action">
                        <div class="header-btn-wrap">
                            @if(setting('language_switcher','permission'))
                            <div class="language-box">
                                <div class="header-lang-item header-lang">
                                    <span class="header-lang-toggle" id="header-lang-toggle"><i
                                            class="fa-regular fa-globe"></i> <span
                                            class="lang-text">{{ localeName() }}</span></span>
                                    <ul id="language-list" class="hidden">
                                        @foreach(\App\Models\Language::where('status',true)->get() as $lang)
                                        <li>
                                            <a href="{{ route('language-update',['name'=> $lang->locale]) }}">{{ $lang->name }}
                                                <span class="icon"></span></a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            
                            @auth('web')
                            <div class="btn-inner d-none d-sm-block">
                                <a class="site-btn blue-btn hover-slide-righ left-right-radius btn-xs"
                                    href="{{ route('user.dashboard') }}"><i class="icon-home"></i>{{ __('Dashboard') }}</a>
                            </div>
                            @else
                            <div class="btn-inner d-none d-sm-block">
                                <a class="site-btn blue-btn hover-slide-righ has-bg-change left-right-radius btn-xs"
                                    href="{{ route('login') }}"><i class="icon-user-add"></i>{{ __('Login/Register') }}</a>
                            </div>
                            @endauth
                        </div>
                        <div class="header-hamburger ml-20 d-xl-none">
                            <div class="sidebar-toggle">
                                <a class="toggle-bar-icon" href="javascript:void(0)">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header section end -->
</header>
<!-- Header area end -->
