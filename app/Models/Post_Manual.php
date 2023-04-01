<?php

namespace App\Models;



class Post {
    
    private static $blog_posts =[
        [
        "title" => "My First Post",
        "slug" => "my-first-post",
        "author" => "Fathan",
        "body" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
        ]
        ,
        [
        "title" => "My Second Post",
        "slug" => "my-second-posts",
        "author" => "Sambo",
        "body" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ."
    
        ]
    ];


    //mengembalikan semua isi dalam blog post
    public static function all(){

        //akses properti statis pakai self::
        //akses biasa menggunakan $this ->
        // return self::$blog_posts;

        //mencoba dengan collection
        return collect(self::$blog_posts);
    }

    public static function find($slug){
        //ambil semua post
        //static:: untuk metode static
        $posts = static::all();
        $post = [];

        // //jika setiap foreach dari blog post sebagai post
        // foreach($posts as $p){
        //     // jika post dengan key slugnya sama dengan slug pada link maka new post akan diisi dengan post yang didapat
        //     if($p["slug"]===$slug){
        //         $post=$p;
        //     }
        // }

        //ambil semua post yang pertama ditemukan sama dengan slug
        return $posts->firstWhere('slug',$slug);
    }
}
