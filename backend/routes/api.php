<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    require base_path('app/Modules/Auth/Routes/api.php');
    require base_path('app/Modules/User/Routes/api.php');
    require base_path('app/Modules/Course/Routes/api.php');
    require base_path('app/Modules/Enrollment/Routes/api.php');
});
