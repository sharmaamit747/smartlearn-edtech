<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Enrollment\Controllers\EnrollmentController;
use App\Modules\Enrollment\Controllers\InstructorEnrollmentController;

Route::prefix('enrollments')
    ->middleware(['auth:sanctum', 'ensure.active'])
    ->group(function () {

        Route::post('/courses/{course}', [EnrollmentController::class, 'store']);
        Route::post('/{enrollment}/cancel', [EnrollmentController::class, 'cancel']);
        Route::post('/{enrollment}/complete', [EnrollmentController::class, 'complete']);
        Route::get('/my', [EnrollmentController::class, 'myEnrollments']);
    });

Route::prefix('instructor')
    ->middleware(['auth:sanctum', 'ensure.active', 'role:instructor'])
    ->group(function () {

        Route::get(
            'courses/{course}/enrollments',
            [InstructorEnrollmentController::class, 'index']
        );
    });
