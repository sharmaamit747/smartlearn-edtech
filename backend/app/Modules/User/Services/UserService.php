<?php

namespace App\Modules\User\Services;

use App\Modules\User\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function listUsers(int $perPage = 15)
    {
        return $this->userRepository->paginate($perPage);
    }
}
