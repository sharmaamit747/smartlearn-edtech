<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('api')->group(function () {

    foreach (['Auth', 'User', 'Course'] as $module) {
        $path = app_path("Modules/{$module}/Routes/api.php");

        if (file_exists($path)) {
            require $path;
        }
    }
});
