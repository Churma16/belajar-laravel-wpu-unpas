<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;


class PostController extends Controller
{
    //halaman post
    public function index()
    {
        $title ='';
        if(request('category')){
            // jika didalam kategori ada isinya maka akan ditambahkan kedalam $title, slug = kolom category
            $category = Category::firstWhere('slug', request('category'));
            $title =' in ' . $category->name;
        }

        if(request('author')){
            // jika didalam kategori ada isinya maka akan ditambahkan kedalam $title
            $author = User::firstWhere('username', request('author'));
            $title =' by ' . $author->name;
        }
        // dd(request('search'));
        //cari data dalam post urutkan paling baru
        $posts = Post::latest();

        //jika didalam kolom search diisi maka tambahkan kueri ke $post latest
        //tugas model bukan controller pindah ke model
        // if (request('search')) {
        //cari berdasarkan juduul
        //     $posts->where('title', 'like', '%' . request('search') . '%')
        //         ->orWhere('body', 'like', '%' . request('search') . '%');
        // }

        return view('posts', [
            "title" => "All Posts" . $title,
            "active" => "post",
            //menjalankan method all untuk akses class static menggunakan titik dua
            // "posts" => Post::all()
            //PERSINGKAT waktu query bisa dipindah kedalam controller
            // "posts" => Post::with(['author','category'])->latest()->get()

            // perintah sebelum ada searchbar
            // "posts" => Post::latest()->get()

            //digunakan saat pencarian didalam controller bukan diluar
            // "posts" => $posts->get()

            //digunakan saat sudah dipindahkan
            //nanti ingin mencari author dan category makannya pake array
            // withquerystring digunakan untuk menambahkan query string pada url
            "posts" => Post::latest()->filter(request(['search','category', 'author']))
            ->paginate(7)->withQueryString()

        ]);
    }

    //halaman single post
    public function show(Post $post)
    {
        return view('post', [
            "title" => "Single Posts",
            "active" => "post",
            //menjalankan method find megambil postingan berdasarkan data slug
            // "post" => Post::find($id)
            "post" => $post
        ]);
    }
}
