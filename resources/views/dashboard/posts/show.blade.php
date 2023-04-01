@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8">
                <h1 class="my-3">{{ $post->title }}</h1>
                {{-- <h5>By: {{ $post->author }}</h5> --}}

                {{-- harus sama pada relation 'category' maka disana juga 'category pada bagian $post->category->slug' --}}
                {{-- pada href $post->author->username bagian 'author' harus sama dengan penulisan relasi yang dipanggil --}}

                <a href="/dashboard/posts" class="btn btn-success"> <span data-feather="arrow-left"
                        class="align-text-bottom"></span>
                    Back to all my posts</a>
                <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"> <span data-feather="edit"
                        class="align-text-bottom"></span>
                    edit</a>
                <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Are You Sure?')"><span data-feather="x-circle"
                            class="align-text-bottom"></span> delete</button>
                </form>
                @if ($post->image)
                {{-- kalau bablas diumpetin --}}
                    <div style="max-height: 350px; overflow:hidden">

                        <img class="img-fluid mt-3" src="{{ asset('storage/' . $post->image) }}">
                    </div>
                @else
                    <img class="img-fluid mt-3" src="https://source.unsplash.com/1200x400?{{ $post->category->name }}">
                @endif

                <article class="my-3 fs-5">
                    {{-- trix sudah menjalankan html special char jadi langusng jadi teks --}}
                    {{-- {{ $post->body }} --}}
                    {!! $post->body !!}
                </article>

            </div>
        </div>
    </div>
@endsection
