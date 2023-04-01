{{-- dump and die var dump - die memberhentikan script apapun setelah --}}
{{-- @dd($posts) --}}

@extends('layouts.main')



@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="/blog" method="GET">
                {{-- mengecek jika di link ada kategori --}}
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="category" value="{{ request('author') }}">
                @endif
                <div class="input-group mb-3">
                    <input type="text" class="form-control rounded-0" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-danger rounded-0" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
    {{-- mengecek jika ada postingan --}}
    @if ($posts->count() > 0)
        <div class="card mb-3">
            @if ($posts[0]->image)
                {{-- kalau bablas diumpetin --}}
                <div style="max-height: 350px; overflow:hidden">
                    <img class="img-fluid" src="{{ asset('storage/' . $posts[0]->image) }}"
                        alt="{{ $posts[0]->category->name }}">
                </div>
            @else
                <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top"
                    alt="{{ $posts[0]->category->name }}">
            @endif
            <div class="card-body text-center">
                <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}"
                        class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
                <p>
                    <small class="text-muted">
                        By: <a class="text-decoration-none"
                            href="/blog?author={{ $posts[0]->author->username }}">{{ $posts[0]->author->name }}</a> in <a
                            class="text-decoration-none"
                            href="/blog?category={{ $posts[0]->category->slug }}">{{ $posts[0]->category->name }}</a>
                        {{-- untuk mengonversi waktu jadi waktu bisa dibaca manusia --}}
                        <p class="card-text"><small class="text-muted">{{ $posts[0]->created_at->diffForHumans() }}</small>
                        </p>
                    </small>
                </p>
                <p class="card-text">{{ $posts[0]->excerpt }}</p>
                <a class="text-decoration-none btn btn-primary" href="/posts/{{ $posts[0]->slug }}">Read more...</a>
            </div>
        </div>


        <div class="container">
            <div class="row">
                @foreach ($posts->skip(1) as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="position-absolute bg-dark px-3 py-2 text-white round"
                                style="background-color:rgba(0,0,0.7)"><a class="text-white text-decoration-none"
                                    href="/blog?category={{ $post->category->slug }}">{{ $post->category->name }}</a>
                            </div>
                            @if ($post->image)
                                {{-- kalau bablas diumpetin --}}
                                <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}">
                            @else
                                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}"
                                    class="card-img-top" alt="...">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p>
                                    <small class="text-muted">
                                        By: <a class="text-decoration-none"
                                            href="/blog?author={{ $post->author->username }}">{{ $post->author->name }}</a>
                                        {{-- untuk mengonversi waktu jadi waktu bisa dibaca manusia --}}
                                        <p class="card-text"><small
                                                class="text-muted">{{ $post->created_at->diffForHumans() }}</small></p>
                                    </small>
                                </p>
                                <p class="card-text">{{ $post->excerpt }}</p>
                                <a href="/posts/{{ $post->slug }}" class="btn btn-primary">Read more...</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No Post found</p>
    @endif
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>

    {{-- untuk looping sederhana --}}
    {{-- @foreach ($posts->skip(1) as $post)
    <article class="mb-5 pb-4 border-bottom">
        <h2>
            <a class="text-decoration-none" href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
        </h2>

        <h5>By: <a class="text-decoration-none" href ="/authors/{{$post->author->username}}">{{ $post->author->name }}</a> in <a class="text-decoration-none" href="/categories/{{ $post->category->slug }}">{{ $post->category->name }}</a></h5>
        <p>{{ $post->excerpt }}</p>
        <a class="text-decoration-none" href="/posts/{{ $post->slug }}">Read more...</a>
    </article>
    @endforeach --}}

@endsection
