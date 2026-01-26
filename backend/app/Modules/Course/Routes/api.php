<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Course\Controllers\CourseController;

Route::prefix('courses')->group(function () {

    Route::get('/', [CourseController::class, 'index']);

    // 🔐 Authenticated routes
    Route::middleware([
        'auth:sanctum',
        'ensure.active',
    ])->group(function () {

        Route::post('/', [CourseController::class, 'store'])
            ->middleware('permission:course.create');

        Route::put('/{course}', [CourseController::class, 'update'])
            ->middleware('permission:course.update');

        Route::delete('/{course}', [CourseController::class, 'destroy'])
            ->middleware('permission:course.delete');
    });
});
