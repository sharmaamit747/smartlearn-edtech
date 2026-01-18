<?php

namespace App\Modules\User\Services;

use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Modules\User\Models\User;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function paginate(Request $request)
    {
        $perPage = min((int) $request->get('per_page', 20), 100);

        return User::query()
            ->select(['id', 'name', 'email', 'status', 'created_at'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }
}
