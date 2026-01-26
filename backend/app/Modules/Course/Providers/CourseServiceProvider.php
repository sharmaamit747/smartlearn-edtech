<?php

namespace App\Modules\Course\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Course\Repositories\Contracts\CourseRepositoryInterface;
use App\Modules\Course\Repositories\CourseRepository;
use Illuminate\Support\Facades\Route;

class CourseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CourseRepositoryInterface::class,
            CourseRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
