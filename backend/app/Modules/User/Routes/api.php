<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\UserController;

Route::middleware(['auth:sanctum', 'permission:user.view'])
    ->prefix('users')
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
    });
