<?php

namespace App\Modules\Course\Policies;

use App\Modules\User\Models\User;
use App\Modules\Course\Models\Course;

class CoursePolicy
{
    public function update(User $user, Course $course): bool
    {
        if ($user->hasPermission('course.update.any')) {
            return true;
        }
        return $user->hasPermission('course.update')
            && $course->created_by === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        if ($user->hasPermission('course.delete.any')) {
            return true;
        }

        return false;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('course.create');
    }
}
