<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // setelah user login bisa ngapain aja, memperluas dari login
        // gerbang 'admin' hanya bisa diakses oleh user tertentu
        // digunakan di kerangka nya
        Gate::define('admin', function(User $user){
            // is_admin maka true
            return $user->is_admin;
        });
    }
}
