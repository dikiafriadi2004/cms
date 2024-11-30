@extends('frontend.layouts.app')

@section('title')
{{ $post->title }}
@endsection

@section('content')
    <section>
        <div class="container mt-150">
            <div class="row col-lg-12 mb-30">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }} }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                    </ol>
                </nav>
                <!-- Article -->
                <div class="col-lg-8 mb-30">
                    <h3 class="medium-header mb-20">
                        {{ $post->title }}
                    </h3>
                    <img src="{{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION') . '/' . $post->thumbnail) }}" class="image-detail mb-10"
                        alt="{{ $post->title }}">
                    <p class="primary-copy">
                        {!! $post->content !!}
                    </p>

                    <!-- Share Sosmed -->
                    <div class="mt-30">
                        <h3 class="share-artikel mb-10">
                            Bagikan Artikel :
                        </h3>
                        <div class="icon-share">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-solid fa-paper-plane"></i></a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- Recent Post -->
                <div class="col-lg-4">
                    <h3 class="small-header">Postingan Terbaru</h3>
                    <hr>
                    <div class="postingan-terbaru">
                        <div class="row">
                            @foreach ($posts as $post)
                            <div class="row col-lg-12 mb-30">
                                <div class="post-terbaru">
                                    <div class="col-lg-3">
                                        <img src="{{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION') . '/' . $post->thumbnail) }}" class="img-artikel-terbaru" alt="">
                                        <div class="date-artikel">
                                            <span class="date-artikel">{{ $post->created_at->isoFormat('D MMM') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 ml-90 mb-10">
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}" class="artikel">
                                            {{ $post->title }}
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <hr class="garis-detail">
                                
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection