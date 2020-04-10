<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Blade::if('teacher', function () {
            if (auth()->user() && auth()->user()->checkRole(2)) {
                return 1;
            }
            return 0;
        });

        $categories = Category::all();
        View::share('categories',$categories);
    }
}
