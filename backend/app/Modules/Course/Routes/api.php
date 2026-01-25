<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Course\Controllers\CourseController;

Route::prefix('v1')->group(function () {

    Route::get('/courses', [CourseController::class, 'index']);

    // 🔐 Authenticated routes
    Route::middleware([
        'auth:sanctum',
        'ensure.active',
    ])->group(function () {

        Route::post('/courses', [CourseController::class, 'store'])
            ->middleware('permission:course.create');

        Route::put('/courses/{course}', [CourseController::class, 'update'])
            ->middleware('permission:course.update');

        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])
            ->middleware('permission:course.delete');
    });
});
