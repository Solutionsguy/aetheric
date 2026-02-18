<!-- Newsletter section start -->
<section class="newsletter-section section-space">
    <div class="container">
        <div class="newsletter-main include-bg" data-background="{{ asset($data['img']) }}">
            <div class="newsletter-grid">
                <div class="content">
                    <p class="description">{{ $data['title_big'] }}</p>
                    <h3 class="title">{{ $data['title_small'] }}</h3>
                </div>
                <div class="newsletter-input-form">
                    <form action="{{ route('subscriber') }}" method="POST">
                        @csrf
                        <input type="text" name="email" placeholder="{{__('Enter your email')}}">
                        <button class="site-btn primary-btn" type="submit">{{__('Submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter section end -->
