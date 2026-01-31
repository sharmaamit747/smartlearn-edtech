<?php

namespace App\Modules\Enrollment\Policies;

use App\Modules\User\Models\User;
use App\Modules\Course\Models\Course;
use App\Modules\Enrollment\Models\Enrollment;

class EnrollmentPolicy
{
    public function create(User $user, Course $course): bool
    {
        // allow attempt, service decides validity
        return true;
    }

    public function cancel(User $user, Enrollment $enrollment): bool
    {
        return $user->id === $enrollment->user_id;
    }

    public function complete(User $user, Enrollment $enrollment): bool
    {
        return $user->id === $enrollment->user_id;
    }
}
