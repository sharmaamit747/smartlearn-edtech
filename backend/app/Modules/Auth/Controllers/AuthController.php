<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Services\AuthService;
use App\Modules\Shared\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(LoginRequest $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Login endpoint placeholder'
        ]);
    }

    public function register(RegisterRequest $request)
    {
        return response()->json([
            'success' => true,
            'success' => 'Register endpoint placeholder'
        ]);
    }
}
