<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\Authcontroller;

Route::prefix('auth')->group(function () {
    Route::post('login', [Authcontroller::class, 'login']);
    Route::post('register', [Authcontroller::class, 'register']);
});
