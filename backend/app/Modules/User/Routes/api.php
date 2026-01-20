<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\UserController;

Route::middleware(['auth:sanctum'])
    ->prefix('users')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware('permission:user.view');
        Route::post('/', [UserController::class, 'store'])->middleware('permission:user.create');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('permission:user.update');
        Route::put('/{user}/self', [UserController::class, 'updateSelf'])->middleware('permission:user.update.self');
        Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('permission:user.delete');
    });
