<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Fathan Muhammad Faqih',
            'username' =>  'fathanmf',
            'email' => 'fathanmf@gmail.com',
            'password' => bcrypt('123456')
        ]);

        // User::create([
        //   'name' => 'Sambo',
        //   'email' => 'Sambo@gmail.com',
        //   'password' => bcrypt('12345')
        // ]);


        // generate 10 data palsu
        \App\Models\User::factory(3)->create();

        Category::create([
            'name' => 'Web Programming',
            'slug' => 'web-programming'
        ]);

        Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        Category::create([
            'name' => 'Web Design',
            'slug' => 'wb-design'
        ]);

        Post::factory(20)->create();
        // Post::create([
        //   'title' => 'Judul Pertama',
        //   'slug'  => 'judul-pertama',
        //   'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, minima!',
        //   'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi totam ullam veritatis officiis voluptates nulla dolorem provident, quibusdam ut minima nobis, aliquid accusamus necessitatibus doloremque rem nisi cupiditate voluptate quas.',
        //   'category_id' => 1,
        //   'user_id'=> 1,
        // ]);

        // Post::create([
        //   'title' => 'Judul Ke Dua',
        //   'slug'  => 'judul-ke-dua',
        //   'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, minima!',
        //   'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi totam ullam veritatis officiis voluptates nulla dolorem provident, quibusdam ut minima nobis, aliquid accusamus necessitatibus doloremque rem nisi cupiditate voluptate quas.',
        //   'category_id' => 1,
        //   'user_id'=> 1,
        // ]);

        // Post::create([
        //   'title' => 'Judul Ke Tiga',
        //   'slug'  => 'judul-ke-tiga',
        //   'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, minima!',
        //   'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi totam ullam veritatis officiis voluptates nulla dolorem provident, quibusdam ut minima nobis, aliquid accusamus necessitatibus doloremque rem nisi cupiditate voluptate quas.',
        //   'category_id' => 2,
        //   'user_id'=> 1,
        // ]);

        // Post::create([
        //   'title' => 'Judul Ke Empat',
        //   'slug'  => 'judul-ke-empat',
        //   'excerpt' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, minima!',
        //   'body' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi totam ullam veritatis officiis voluptates nulla dolorem provident, quibusdam ut minima nobis, aliquid accusamus necessitatibus doloremque rem nisi cupiditate voluptate quas.',
        //   'category_id' => 2,
        //   'user_id'=> 2,
        // ]);

    }
}
