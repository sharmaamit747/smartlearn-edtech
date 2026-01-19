<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\UserController;

Route::middleware(['auth:sanctum'])
    ->prefix('users')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:user.view');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:user.create');
    });
