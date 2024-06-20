<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
        // URL::forceScheme('https');
        RedirectIfAuthenticated::redirectUsing(function () {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            } elseif ($user->hasRole('teacher')) {
                return route('teacher.dashboard');
            } elseif ($user->hasRole('student')) {
                return route('student.dashboard');
            } else {
                return route('home');
            }
        });
    }
}
