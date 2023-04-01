<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory, Sluggable;

    //yang boleh
    // protected $fillable = ['title', 'excerpt',  'body'];

    //yang gaboleh
    protected $guarded = ['id'];
    protected $with = ['category', 'author'];

    public function scopeFilter($query, array $filters)
    {
        // request kerjaan controller bukan model
        // if (request('search')) {

        // kalau didalam variabel filters ada search maka ambil apapun yang ada didalamnya, kalau tidak ada
        // tidak dikerjakan querynya maka langsung get where di skip
        // if (isset($filters['search']) ? $filters['search'] : false) {
        // cari berdasarkan juduul
        //     return $query->where('title', 'like', '%' . $filters['search'] . '%')
        //         ->orWhere('body', 'like', '%' . $filters['search'] . '%');
        // }
        // jika benar ambil yang ada didalam search, flters search masuk ke search, query masuk ke query
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
        });

        $query->when($filters['category']?? false, function($query,$category){
            // join, belongs to, menggunakan use supaya yang diatas terpakai
            return $query->whereHas('category', function($query) use ($category){
                $query->where('slug', $category);
            });
        });

        $query->when($filters['author']?? false, fn($query,$author) =>
            $query->whereHas('author', fn($query)=>
            // ngambilnya dari username bukan slug
                $query->where('username',$author)
            )
        );
    }
    public function category()
    {
        // model post ini terhubung dengan category 1 to 1
        return $this->belongsTo(Category::class);
    }

    // public function user(){
    //   return $this->belongsTo(User::class);
    // }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // mencari berdasarkan slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    //membuat slug otomatis
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
