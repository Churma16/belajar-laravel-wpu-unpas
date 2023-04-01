<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
// untuk excerpt
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // method index akan mengembalikan view dengan nama dashboard.posts.index
    // method index akan mengembalikan data post yang user id nya sama dengan user yang sedang login

    public function index()
    {
        // kembalikan post yang user id nya sama dengan user yang sedang login
        return view('dashboard.posts.index', [
            'posts' => Post::where('user_id', auth()->user()->id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // method create akan mengembalikan view dengan nama dashboard.posts.create
    // method create akan mengembalikan data category yang akan digunakan untuk menampilkan dropdown
    // pada form create post 
    public function create()
    {
        // nampilin
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // method store akan dipanggil ketika kita mengirimkan form create post
    // method store akan menerima parameter request yang digunakan untuk mengambil data yang dikirimkan oleh user
    // method store akan mengembalikan redirect ke halaman dashboard.posts.index
    // method store akan mengembalikan flash message success
    // method store akan mengembalikan flash message New post has been added!
    public function store(Request $request)
    {
        // proses data
        // validasi data yang dikirimkan oleh user 
        // jika data tidak valid maka akan kembali ke halaman sebelumnya
        // request menerima semua data yang dikirimkan dari form

        // akan menyimpan file apapun ke folder
        // path dapat diubah di file config

        // return $request->file('image')->store('post-image');

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image'=> 'image|file|max:4000',
            'body' => 'required'
        ]);

        // kode dibawah menjelaskan jika ada file yang dikirimkan maka akan disimpan di folder post-image 
        if($request->file('image')){
            $validatedData['image']= $request->file('image')->store('post-image');
        }
        // menambahkan array user id diisi id yang sedang login
        $validatedData['user_id'] = auth()->user()->id;
        // strip menghapus tag
        // limit untuk membatasi jumlah karakter yang akan ditampilkan 
        // 200 untuk jumlah karakter yang akan ditampilkan
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');
        Post::create($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'post' => $post

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    // merupakan method yang akan dipanggil ketika kita mengakses halaman edit
    // menerima parameter request dan post yang merupakan model post yang akan diedit 
    // parameter request digunakan untuk mengambil data yang dikirimkan oleh user
    // parameter post digunakan untuk mengambil data post yang akan diedit
    // method edit akan mengembalikan view dengan nama dashboard.posts.edit
    //
    public function edit(Request $request, Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = ([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image'=> 'image|file|max:4000',
            'body' => 'required'
        ]);

        if($request->file('image')){
            $validatedData['image']= $request->file('image')->store('post-image');
        }

        // jika slug tidak sama dengan slug yang ada di database
        if ($request->slug != $post->slug) {
            // maka validasi slug harus unik
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        //pastikan dibawah validasi
        if($request->file('image')){
            //jika ada gambar baru ganti gambar lama, maka hapus gambar lama dulu
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validatedData['image']= $request->file('image')->store('post-image');
        }

        // menambahkan array user id diisi id yang sedang login
        $validatedData['user_id'] = auth()->user()->id;
        // strip menghapus tag
        // limit untuk membatasi jumlah karakter yang akan ditampilkan 
        // 200 untuk jumlah karakter yang akan ditampilkan
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');

        Post::where('id', $post->id)->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New post has been update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //hapus data post delete image dulu baru delete di tabel
        if($post->image){
            Storage::delete($post->image);
        }
        // menerima data yang dikirim pada index
        // menghapus data post yang id nya sama dengan id yang dikirimkan

        Post::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'Post has been deleted!');
    }

    // method checkSlug akan dipanggil ketika kita mengirimkan request ajax untuk mengecek apakah slug sudah ada atau belum 
    // method checkSlug akan menerima parameter request yang digunakan untuk mengambil data yang dikirimkan oleh user
    // method checkSlug akan mengembalikan response json dengan key slug dan value slug
    public function checkSlug(Request $request)
    {
        // menggunakan method create slug dari kelas post dengan ngambil dari field slug dengan title nya apa
        // bisa mengecek apakah ada slug sama
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        // mengirim array assosiatif yang key nya slug dan isinya slug
        return  response()->json(['slug' => $slug]);
    }
}
