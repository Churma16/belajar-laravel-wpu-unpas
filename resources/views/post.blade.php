@extends('layouts.main')
@dd($post)
@section('container')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h2 class="mb-4">{{ $post->title }}</h2>
                {{-- <h5>By: {{ $post->author }}</h5> --}}

                {{-- harus sama pada relation 'category' maka disana juga 'category pada bagian $post->category->slug' --}}
                {{-- pada href $post->author->username bagian 'author' harus sama dengan penulisan relasi yang dipanggil --}}
                <h5>By: <a class="text-decoration-none"
                        href="/blog?author={{ $post->author->username }}">{{ $post->author->name }}</a> in <a
                        href="/blog?category={{ $post->category->slug }}">{{ $post->category->name }}</a></h5>
                @if ($post->image)
                    {{-- kalau bablas diumpetin --}}
                    <div style="max-height: 350px; overflow:hidden">

                        <img class="img-fluid " src="{{ asset('storage/' . $post->image) }}">
                    </div>
                @else
                    <img class="img-fluid " src="https://source.unsplash.com/1200x400?{{ $post->category->name }}">
                @endif
                <article class="my-3 fs-5">
                    {{-- sudah menjalankan html special char jadi langusng jadi teks --}}
                    {{-- {{ $post->body }} --}}
                    {!! $post->body !!}
                    <a class="d-block mt-3" href="/blog">Back to Posts</a>
                </article>

            </div>
        </div>
    </div>
@endsection
