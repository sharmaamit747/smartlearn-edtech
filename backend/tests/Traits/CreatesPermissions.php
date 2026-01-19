<?php

namespace Tests\Traits;

use App\Modules\Shared\RBAC\Models\Permission;
use Illuminate\Support\Str;

trait CreatesPermissions
{
    protected function createPermission(string $slug, ?string $name = null): Permission
    {
        return Permission::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => $name ?? Str::headline(str_replace('.', ' ', $slug)),
            ]
        );
    }
}
