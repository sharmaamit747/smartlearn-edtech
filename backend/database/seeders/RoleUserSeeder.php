<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use App\Modules\Shared\RBAC\Models\Role;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->firstOrFail();
        $studentRole = Role::where('slug', 'student')->firstOrFail();
        $instructorRole = Role::where('slug', 'instructor')->firstOrFail();

        // Admin
        User::where('email', 'admin@example.com')->first()?->roles()
            ->syncWithoutDetaching([$adminRole->id]);

        // Student
        User::where('email', 'student@example.com')->first()?->roles()
            ->syncWithoutDetaching([$studentRole->id]);

        // Instructor
        User::where('email', 'instructor@example.com')->first()?->roles()
            ->syncWithoutDetaching([$instructorRole->id]);
    }
}
