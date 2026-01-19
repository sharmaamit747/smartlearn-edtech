<?php

namespace Tests\Traits;

use App\Modules\User\Models\User;
use App\Modules\Shared\RBAC\Models\Role;

trait CreatesUsers
{
    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    protected function createUserWithRole(Role $role): User
    {
        $user = User::factory()->create();
        $user->roles()->attach($role);

        return $user;
    }
}
