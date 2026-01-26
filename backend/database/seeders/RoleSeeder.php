<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Shared\RBAC\Models\Role;
use App\Modules\Shared\RBAC\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $admin = Role::firstOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        $student = Role::firstOrCreate(['slug' => 'student'], ['name' => 'Student']);
        $instructor = Role::firstOrCreate(['slug' => 'instructor'], ['name' => 'Instructor']);

        // Admin → all permissions (if any exist)
        $admin->permissions()->sync(Permission::pluck('id'));

        // Self update permission (SAFE)
        $selfUpdatePermission = Permission::where('slug', 'user.update.self')->first();

        if ($selfUpdatePermission) {
            $student->permissions()->syncWithoutDetaching([$selfUpdatePermission->id]);
            $instructor->permissions()->syncWithoutDetaching([$selfUpdatePermission->id]);
        }
    }
}
