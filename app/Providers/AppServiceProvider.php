<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Category;
use App\Slideshow;
use App\Shop;
use App\Http\Controllers\Helper\Cart;

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
        Schema::defaultStringLength(191);
        
        view()->composer('home.index', function($view) {
            $categories = Category::with(['subCategories', 'products' => function($query) {
                $query->with('photos')->where('active', 1)->limit(15);
            }])->whereNull('parent_id')->where('active', 1)->get();

            $view->with('categories', $categories);
        });

        view()->composer(['home.category', 'home.details', 'home.search', 'home.contact', 'home.about', 'cart.*', 'notfound'], function($view) {
            $categories = Category::with(['subCategories'])->whereNull('parent_id')->where('active', 1)->get();

            $view->with('categories', $categories);
        });

        view()->composer(['home.*', 'cart.*', 'notfound'], function($view) {
            $carts = Cart::getInstance()->getAllCart();
            $info = Shop::first();

            $view->with('carts', $carts)->with('info', $info);
        });

        view()->composer('home.*', function($view) {
            $slideshow = Slideshow::where('active', 1)->get();

            $view->with('slideshow', $slideshow);
        });
    }
}
