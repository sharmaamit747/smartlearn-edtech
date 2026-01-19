<?php

namespace App\Modules\User\Services;

use Symfony\Component\HttpFoundation\Request;
use App\Modules\User\Models\User;

class UserService
{
    public function __construct() {}

    public function getUserList(Request $request)
    {
        $perPage = min((int) $request->get('per_page', 20), 100);

        return User::query()
            ->select(['id', 'name', 'email', 'status', 'created_at'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }
}
