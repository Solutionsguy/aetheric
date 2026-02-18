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

@php
$blogs = \App\Models\Blog::where('locale',app()->getLocale())->latest()->paginate(9);
@endphp

<!-- Blog area start -->
<div class="blog-area position-relative fix section-space" data-aos="fade-up" data-aos-duration="15 00">
    <div class="container">
        <div class="row gy-50">
            @foreach($blogs as $blog)
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                <article class="blog-grid-item style-two">
                    <div class="blog-thumb">
                        <a href="{{ route('blog-details',$blog->id) }}">
                            <img src="{{ asset($blog->cover) }}"
                                alt="{{ $blog->title }}">
                        </a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span>{{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</span>
                        </div>
                        <h3 class="blog-title">
                            <a href="{{ route('blog-details',$blog->id) }}">
                                {!! Str::words(strip_tags($blog->details), 20, '...') !!}
                            </a>
                        </h3>
                        <a class="text-btn" href="{{ route('blog-details',$blog->id) }}">{{ __('Read More') }} <i class="icon-arrow-right-1"></i></a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-center mt-10">
            <div class="col-xxl-12">
                <div class="site-pagination pagination-secondary text-center">
                    {{ $blogs->links('frontend::pagination.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog area start -->

<!-- Newsletter section start -->
@include('frontend::pages.newsletter')
<!-- Newsletter section end -->
@endsection
