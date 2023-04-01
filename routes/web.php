<?php

use App\Http\Controllers\AdminCategoryController;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// jika ada rute dengan metode request get (akses url) dengan alamat slash (tidak ada apa apa)
// maka akan menjalankan rute ini atau fungsi ini, fungsi yang dijalankan adalah fungsi view
// (bisa ditulis apapun)
Route::get('/', function () {

    //mencari file welcome dalam folder view
    return view('home', [
        "title" => "Home",
        "active" => "home"
    ]);
});

//function sama dengan closure yaitu anonym func
Route::get('/about', function () {

    return view('about', [
        "title" => "About",
        "name" => "Fathan Muhammad Faqih",
        "email" => "tstrgame@gmail.com",
        "img" => "jellyfish.jpg",
        "active" => "about",
    ]);
});

Route::get('/blog', [PostController::class, 'index']);

//Halaman single post
// wild card ngambil apapun isi dari slash dikondisi ini dia ngambil isi dari slug yang tampil
// route::get('posts/{id}', [PostController::class,'show']);
//mencari where slug = yang diinginkan route model binding
route::get('posts/{post:slug}', [PostController::class, 'show']);


Route::get('/categories', function () {
    return view('categories', [
        'title' => 'Categories',
        'active' => 'categories',
        'categories' => Category::all()
    ]);
});


//sudah tidak terpakai13
//yang dikirim slug
Route::get('/categories/{category:slug}', function (Category $category) {
    return view('posts', [
        'title' => "Post by Category: $category->name",
        //1 kategori punya banyak post
        'posts' => $category->posts->load('category', 'author'),
        'active' => 'categories',
        // 'category' => $category->name
    ]);
});

//sudah tidak terpakai 13
// yang dikirim username harus sama
Route::get('authors/{author:username}', function (User $author) {
    return view('posts', [
        'title' => "Post By Author: $author->name",
        'active' => 'posts',
        // 'posts' => $author->posts,
        //lazy eager
        'posts' => $author->posts->load('author', 'category'),
    ]);
});

//langkah pertama buat controller yang didalamnya ada method index
//jika ada request ke url get dengan metode login maka jalankan controller login method index
//middleware berguna untuk menjaga halaman tertentu hanya untuk user yang sudah login, ngubah redirect nya di service provider
// app\Providers\RouteServiceProvider.php
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

//untuk mengganti arah redirect default middleware bisa ke app\Http\Middleware\Authenticate.php
// untuk kalkulasi data
// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');


// membuat slug otomatis
Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug']);
// sayang, cara ngakalinnya ditambahkan pada model
// Route::get('dashboard/post/{post:slug}');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

// semuanya bukan sebagian kecil
// gampang untuk banyak method sekaligus
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');
// tanpa middleware
// Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show');