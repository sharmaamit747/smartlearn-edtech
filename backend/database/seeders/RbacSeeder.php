<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Shared\RBAC\Models\Permission;
use App\Modules\Shared\RBAC\Models\Role;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'course.create',
            'course.update',
            'course.delete',
            'course.view',
            'course.view.all',
            'course.create',
            'course.update.any',
            'course.delete.any',
            'course.publish',
            'course.publish.any',
            'course.enroll',
            'enrollment.create',
            'enrollment.cancel',
            'enrollment.complete',
            'enrollment.view.self',
            'enrollment.view.course',
            'enrollment.view.any',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'slug' => $perm,
                'name' => ucfirst(str_replace('.', ' ', $perm)),
            ]);
        }

        $admin = Role::where('slug', 'admin')->first();
        $instructor = Role::where('slug', 'instructor')->first();
        $student = Role::where('slug', 'student')->first();

        // Admin → all
        $admin->permissions()->syncWithoutDetaching(
            Permission::whereIn('slug', $permissions)->pluck('id')
        );

        // Instructor → create/update/view
        $instructor->permissions()->syncWithoutDetaching(
            Permission::whereIn('slug', [
                'course.create',
                'course.update',
                'course.view',
                'course.publish',
                'enrollment.view.course',
                'enrollment.complete',
            ])->pluck('id')
        );

        // Student → view only
        $student->permissions()->syncWithoutDetaching(
            Permission::whereIn('slug', [
                'course.view',
                'course.enroll',
                'enrollment.create',
                'enrollment.cancel',
                'enrollment.view.self',
            ])->pluck('id')
        );
    }
}
