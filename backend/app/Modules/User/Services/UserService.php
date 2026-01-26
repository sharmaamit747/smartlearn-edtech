<?php

namespace App\Modules\User\Services;

use Symfony\Component\HttpFoundation\Request;
use App\Modules\User\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

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

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => User::STATUS_ACTIVE,
        ]);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user->refresh();
    }

    public function updateSelf(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
        ]);

        return $user->refresh();
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function updateStatus(User $user, string $status): User
    {
        $user->update(['status' => $status]);

        return $user;
    }
}
