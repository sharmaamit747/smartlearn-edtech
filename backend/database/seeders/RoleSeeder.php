<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Shared\RBAC\Models\Role;
use App\Modules\Shared\RBAC\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);

        $admin->permissions()->sync(
            Permission::pluck('id')
        );
    }
}
