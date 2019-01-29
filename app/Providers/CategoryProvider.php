<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use App\AdditionalFeature;

class CategoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("*",function($view) {
            $providerCategories = Category::withCount('products')->latest()->get();

            $view->with([
              'providerCategories'=> $providerCategories
            ]);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
