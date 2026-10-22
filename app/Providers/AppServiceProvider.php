<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('frontend.partials.nav', function ($view) {
            $count = Cart::where('session_id', session()->getId())->count();
            $view->with('cartCount', $count);
        });
    }
}
