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
    <div class="blog-area position-relative fix section-space-top" data-aos="fade-up" data-aos-duration="15 00">
        <div class="container">
            <div class="row gy-30">
                @foreach($blogs as $blog)
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <article class="blog-grid-item style-one">
                        <div class="blog-thumb">
                            <a href="{{ route('blog-details',$blog->id) }}"><img src="{{ asset($blog->cover) }}" alt="{{ $blog->title }}"></a>
                        </div>
                        <div class="blog-content">
                            <h3 class="blog-title"><a href="{{ route('blog-details',$blog->id) }}">{{ $blog->title }} </a></h3>
                            <p class="description">{!! Str::words(strip_tags($blog->details), 20, '...') !!}</p>
                            <a class="site-btn primary-btn btn-xs" href="{{ route('blog-details',$blog->id) }}">Read More<i class="icon-arrow-right-2"></i></a>
                            <div class="blog-date">
                               <span>
                                  <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d F') }}</span>
                               </span>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            {{ $blogs->links('frontend::pagination.pagination') }}
        </div>
    </div>
    <!-- Blog area end -->

    <!-- Newsletter section start -->
    @include('frontend::pages.newsletter')
    <!-- Newsletter section end -->
@endsection
