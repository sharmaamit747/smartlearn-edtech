<?php

namespace App\Modules\Enrollment\Policies;

use App\Modules\User\Models\User;
use App\Modules\Enrollment\Models\Enrollment;

class EnrollmentPolicy
{
    public function create(User $user): bool
    {
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

    /**
     * Student: view own enrollments
     */
    public function viewSelf(User $user): bool
    {
        return $user->hasPermission('enrollment.view.self');
    }

    /**
     * Admin: view all enrollments
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('enrollment.view.any');
    }

    /**
     * Single enrollment access safety
     */
    public function view(User $user, Enrollment $enrollment): bool
    {
        if ($user->hasPermission('enrollment.view.any')) {
            return true;
        }

        return $user->hasPermission('enrollment.view.self')
            && $enrollment->user_id === $user->id;
    }
}
