@extends('frontend::pages.index')
@section('title')
    {{ $data->title }}
@endsection
@section('meta_keywords')
    {{ $data['meta_keywords'] }}
@endsection
@section('meta_description')
    {{ $data['meta_description'] }}
@endsection
@section('page-content')
    <!-- Postbox area start -->
    <section class="postbox-area position-relative fix section-space-top" data-aos="fade-up" data-aos-duration="15 00">
        <div class="container">
            <div class="row g-40">
                <div class="col-xxl-8 col-xl-8 col-lg-7">
                    <div class="postbox-wrapper">
                        <h4>
                            <img src="{{ asset($blog->cover) }}" alt="postbox thumb">
                        </h4>
                        <div class="postbox-share">
                            <h4>{{ $blog->title }}</h4>

                        </div>{!! $blog->details !!}
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-5">
                    <div class="postbox-sidebar-wrapper sidebar-active-sticky">
                        <div class="sidebar-widget">
                            <h3 class="sidebar-widget-title">Related Post</h3>
                            <div class="sidebar-widget-content">
                                <div class="sidebar-post">
                                    @foreach($blogs as $blog)
                                    <div class="rc-post-item">
                                        <div class="rc-post-thumb">
                                            <a href="{{ route('blog-details',$blog->id) }}"><img src="{{ asset($blog->cover) }}"
                                                                             alt="image not found"></a>
                                        </div>
                                        <div class="rc-post-content">
                                            <div class="rc-meta">
                                                <p>{{ $blog->created_at }}</p>
                                            </div>
                                            <h5 class="rc-post-title">
                                                <a href="{{ route('blog-details',$blog->id) }}">{!! Str::words(strip_tags($blog->details), 20, '...') !!}</a>
                                            </h5>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Newsletter section start -->
    @include('frontend::pages.newsletter')
    <!-- Newsletter section end -->
@endsection
