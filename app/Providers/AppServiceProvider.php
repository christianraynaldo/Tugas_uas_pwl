<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $cartCount = 0;

            if (Auth::guard('konsumen')->check()) {
                $cartCount = Cart::where('konsumen_id', Auth::guard('konsumen')->id())->sum('jumlah');
            } else {
                // Hitung total qty dari session (untuk user belum login)
                $cartSession = session('cart', []);
                $cartCount = array_sum(array_column($cartSession, 'jumlah'));
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
