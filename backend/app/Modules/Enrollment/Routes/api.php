<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Enrollment\Controllers\EnrollmentController;

Route::prefix('enrollments')
    ->middleware(['auth:sanctum', 'ensure.active'])
    ->group(function () {

        Route::post('/courses/{course}', [EnrollmentController::class, 'store']);
        Route::post('/{enrollment}/cancel', [EnrollmentController::class, 'cancel']);
        Route::post('/{enrollment}/complete', [EnrollmentController::class, 'complete']);
    });
