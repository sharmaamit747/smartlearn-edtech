<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class RBACServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Optional: bind RBAC-related services here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasPermission($ability) ?: null;
        });
    }
}
