<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('enrollments', function (Request $request) {
            return match (true) {
                $request->user()?->hasRole('admin')      => Limit::perMinute(120),
                $request->user()?->hasRole('instructor') => Limit::perMinute(60),
                default                                 => Limit::perMinute(30),
            };
        });
    }
}
