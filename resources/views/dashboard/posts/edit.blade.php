@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Post</h1>
    </div>

    <div class="col-lg-8">

        {{-- dengan method post akan mengarahkan ke method create --}}
        <form method="post" class="mb-5" action="/dashboard/posts/{{ $post->slug }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror " id="title"
                    name="title" value="{{ old('title', $post->title) }}" required autofocus>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    value="{{ old('slug', $post->slug) }}" readonly required>
                @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Post Image</label>
                <input type="hidden" name="oldImage" value="{{ $post->image }}">
                @if ($post->image)
                    <img src="{{ asset('storage/'.$post->image) }}"class="img-preview img-fluid mb-3 col-sm-5 d-block">
                @else
                    <img class="img-preview img-fluid mb-3 col-sm-5 d-block">
                @endif
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                    name="image" onchange="previewImage()">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                    @foreach ($categories as $category)
                        @if (old('category_id', $post->category_id) == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
                <trix-editor input="body"></trix-editor>

            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>


    <script>
        // {{-- fetch api untuk isi otomatis --}}
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        // saat diubah pindah tab
        // karena menggunakan get bisa langsung kirim data
        title.addEventListener('change', function() {
            // mengfetch data dari controller request mengoah data value pada name title
            fetch('/dashboard/posts/checkSlug?title=' + title.value)
                // masih prompts
                .then(response => response.json())
                // mengisi isi dari slug(value) akan diambil dari data dengan properti slug
                .then(data => slug.value = data.slug)
        })

        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })

        //kode dibawah iniakan menampilkan preview image untuk inputan image
        function previewImage() {
            // mengambil id image
            const image = document.querySelector('#image');
            // mengambil class img-preview
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            // mengambil file yang diinputkan, ofReader untuk membaca file yang diinputkan dan mengubahnya 
            // menjadi base64 string yang akan dijadikan src dari imgPreview yang akan ditampilkan di halaman 
            // web kita 
            const oFReader = new FileReader();

            // membaca file yang diinputkan dan mengubahnya menjadi base64 string 
            oFReader.readAsDataURL(image.files[0]);

            // ketika file sudah dibaca, maka akan menjalankan fungsi berikut  
            // oFREvent adalah event yang terjadi ketika file sudah dibaca 
            oFReader.onload = function(oFREvent) {
                //oFREvent.target.result adalah hasil dari pembacaan file yang diinputkan
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection


{{-- easier slug making --}}
{{-- <script>
    const title = document.querySelector("#title");
    const slug = document.querySelector("#slug");

    title.addEventListener("keyup", function() {
        let preslug = title.value;
        preslug = preslug.replace(/ /g,"-");
        slug.value = preslug.toLowerCase();
    });
</script> --}}
