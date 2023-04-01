<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //sama dengan yang dikirim pada route
    
    public function posts(){
      //satu kategori memiliki banyak post
        return $this ->hasMany(Post::class);
    }
}
