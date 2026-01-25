<?php

namespace App\Modules\Course\Policies;

use App\Modules\User\Models\User;
use App\Modules\Course\Models\Course;

class CoursePolicy
{
    public function update(User $user, Course $course): bool
    {
        return $user->hasRole('admin') || $course->created_by === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $this->update($user, $course);
    }

    public function view(User $user, Course $course): bool
    {
        if ($course->status === Course::STATUS_PUBLISHED) {
            return true;
        }

        return $this->update($user, $course);
    }
}
