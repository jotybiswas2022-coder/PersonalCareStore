<?php

namespace App\Providers;

use App\Listeners\MergeGuestCart;
use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(Login::class, MergeGuestCart::class);

        View::composer('frontend.partials.nav', function ($view) {
            $count = Cart::forCurrentOwner()->count();
            $view->with('cartCount', $count);
        });
    }
}
