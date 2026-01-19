<?php

namespace Tests\Traits;

use App\Modules\Shared\RBAC\Models\Role;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;

trait ActsAsAdmin
{
    protected function actingAsAdmin(): void
    {
        $role = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin']
        );

        $user = $this->createUserWithRole($role);

        Sanctum::actingAs($user);
    }
}
