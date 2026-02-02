<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Enrollment\Controllers\EnrollmentController;
use App\Modules\Enrollment\Controllers\InstructorEnrollmentController;
use App\Modules\Enrollment\Controllers\AdminEnrollmentController;

/*
|--------------------------------------------------------------------------
| Student Enrollments
|--------------------------------------------------------------------------
*/

Route::prefix('enrollments')
    ->middleware(['auth:sanctum', 'ensure.active'])
    ->group(function () {

        // Enroll in a course
        Route::post('courses/{course}', [EnrollmentController::class, 'store']);

        // Cancel enrollment
        Route::post('{enrollment}/cancel', [EnrollmentController::class, 'cancel']);

        // Complete enrollment
        Route::post('{enrollment}/complete', [EnrollmentController::class, 'complete']);

        // Logged-in student's enrollments
        Route::get('my', [EnrollmentController::class, 'myEnrollments']);
    });

/*
|--------------------------------------------------------------------------
| Instructor Enrollments
|--------------------------------------------------------------------------
*/
Route::prefix('instructor')
    ->middleware(['auth:sanctum', 'ensure.active'])
    ->group(function () {

        // Enrollments for instructor's course
        Route::get('courses/{course}/enrollments', [
            InstructorEnrollmentController::class,
            'index'
        ]);
    });

/*
|--------------------------------------------------------------------------
| Admin Enrollments Control
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth:sanctum', 'ensure.active'])
    ->group(function () {
        Route::get(
            '/enrollments',
            [AdminEnrollmentController::class, 'index']
        );
    });
