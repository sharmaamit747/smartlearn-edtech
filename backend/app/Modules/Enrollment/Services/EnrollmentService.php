<?php

namespace App\Modules\Enrollment\Services;

use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\Course\Models\Course;
use App\Modules\User\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class EnrollmentService
{
    /**
     * Enroll a user into a course
     */
    public function enroll(User $user, Course $course): Enrollment
    {
        // 1️⃣ Business rules first
        if ($course->status !== Course::STATUS_PUBLISHED) {
            throw ValidationException::withMessages([
                'course' => 'Course is not published',
            ]);
        }

        if ($course->created_by === $user->id) {
            throw new AuthorizationException('Instructor cannot enroll in own course');
        }

        if (
            Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists()
        ) {
            throw ValidationException::withMessages([
                'course' => 'Already enrolled',
            ]);
        }

        // 3️⃣ Create enrollment
        return Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => Enrollment::STATUS_ACTIVE,
        ]);
    }


    /**
     * Cancel enrollment
     */
    public function cancel(Enrollment $enrollment): Enrollment
    {
        if ($enrollment->status !== Enrollment::STATUS_ACTIVE) {
            throw ValidationException::withMessages([
                'enrollment' => 'Only active enrollments can be cancelled',
            ]);
        }

        $enrollment->update([
            'status'        => Enrollment::STATUS_CANCELLED,
            'cancelled_at'  => now(),
        ]);

        return $enrollment;
    }

    /**
     * Mark enrollment as completed
     */
    public function complete(Enrollment $enrollment): Enrollment
    {
        if ($enrollment->status !== Enrollment::STATUS_ACTIVE) {
            throw ValidationException::withMessages([
                'enrollment' => 'Enrollment cannot be completed',
            ]);
        }

        $enrollment->update([
            'status'        => Enrollment::STATUS_COMPLETED,
            'completed_at'  => now(),
        ]);

        return $enrollment;
    }

    /**
     * Check if already enrolled
     */
    protected function isAlreadyEnrolled(int $userId, int $courseId): bool
    {
        return Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->whereIn('status', [
                Enrollment::STATUS_ACTIVE,
                Enrollment::STATUS_COMPLETED,
            ])
            ->exists();
    }
}
