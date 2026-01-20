<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Modules\User\Services\UserService;
use App\Modules\User\Resources\UserResource;
use App\Modules\User\Requests\CreateUserRequest;
use App\Modules\User\Requests\UpdateSelfUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\Models\User;


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

    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->create($request->validated());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $updated = $this->userService->update($user, $request->validated());

        return new UserResource($updated);
    }

    public function updateSelf(UpdateSelfUserRequest $request, User $user)
    {
        if ($request->user()->id !== $user->id) {
            abort(403);
        }

        $updated = $this->userService->updateSelf($user, $request->validated());

        return new UserResource($updated);
    }

    public function destroy(User $user): JsonResponse
    {
        if (auth()->id() === $user->id) {
            abort(403, 'You cannot delete your own account');
        }

        $this->userService->delete($user);

        return response()->json([
            'message' => 'User deleted successfully',
        ], 200);
    }
}
