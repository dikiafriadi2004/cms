@extends('frontend.layouts.app')

@section('title')
    Blog
@endsection

@section('content')
    <section>
        <div class="container mt-150">
            <div class="row col-lg-12 mb-30">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <h3 class="medium-header mb-30">
                            BLOG
                        </h3>
                    </div>
                </div>
                @foreach ($posts as $post)
                    <div class="col-lg-4 mb-30">
                        <div class="card">
                            <img src="{{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION') . '/' . $post->thumbnail) }}"
                                class="card-img-top" alt="{{ $post->title }}">
                            <div class="card-body">
                                <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                    class="card-title-blog">{{ $post->title }}</a>
                                <p class="card-text-blog">{{ $post->description }}</p>
                                <span class="date-blog">{{ $post->created_at->isoFormat('D MMMM Y') }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
    </section>
@endsection