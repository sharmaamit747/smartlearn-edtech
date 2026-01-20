<?php

namespace Tests\Traits;

use App\Modules\Shared\RBAC\Models\Permission;

trait CreatesPermissions
{
    protected function createPermission(string $slug): Permission
    {
        return Permission::firstOrCreate(
            ['slug' => $slug],
            ['name' => ucwords(str_replace('.', ' ', $slug))]
        );
    }

    protected function seedUserPermissions(): void
    {
        $permissions = [
            'user.view',
            'user.create',
            'user.update',
            'user.update.self',
        ];

        foreach ($permissions as $permission) {
            $this->createPermission($permission);
        }
    }
}
