<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Shared\RBAC\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'user.update.self',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'slug' => $perm,
                'name' => ucfirst(str_replace('.', ' ', $perm)),
            ]);
        }
    }
}
