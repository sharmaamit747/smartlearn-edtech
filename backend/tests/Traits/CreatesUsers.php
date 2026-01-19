<?php

namespace Tests\Traits;

use App\Modules\User\Models\User;
use App\Modules\Shared\RBAC\Models\Role;
use App\Modules\Shared\RBAC\Models\Permission;

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

    protected function createAdminUser(): User
    {
        $adminRole = Role::where('slug', 'admin')->firstOrFail();

        $permission = Permission::where('slug', 'user.create')->firstOrFail();
        $adminRole->permissions()->syncWithoutDetaching([$permission->id]);

        $user = User::factory()->create();
        $user->roles()->attach($adminRole);

        return $user;
    }
}
