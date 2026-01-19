<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Modules\User\Services\UserService;
use App\Modules\User\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(Request $request)
    {
        $users = $this->userService->getUserList($request);
        return UserResource::collection($users);
    }
}
