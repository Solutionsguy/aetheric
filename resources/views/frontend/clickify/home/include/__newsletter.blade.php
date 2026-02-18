
<!-- Newsletter section start -->
<section class="newsletter-section-two section-space">
    <div class="container">
        <div class="wrapper">
            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-8">
                    <div class="newsletter-wrapper style-two">
                        <div class="content">
                            <div class="section-title-wrapper mb-35">
                                <h2 class="section-title mb-30">{{ $data['title'] }}</h2>
                                <p class="b2 description">
                                    {{ $data['description'] }}
                                </p>
                            </div>
                            <div class="newsletter-input-form-two">
                                <form action="{{ route('subscriber') }}" method="POST">
                                    @csrf
                                    <input type="text" name="email" placeholder="{{ __('Enter your email') }}">
                                    <button class="site-btn blue-btn hover-slide-righ left-right-radius btn-xs"
                                        type="submit"> <i class=""></i> {{ __('Submit') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="newsletter-shapes">
                <div class="shape-one">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/newslatter/shape-01.svg" alt="newslatter shape">
                </div>
                <div class="shape-two">
                    <img src="{{ asset('/') }}/frontend/default/images/shapes/newslatter/shape-02.svg" alt="newslatter shapes">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter section end -->
