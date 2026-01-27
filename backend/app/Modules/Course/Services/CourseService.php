<?php

namespace App\Modules\Course\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Modules\Course\Models\Course;
use App\Modules\Course\Repositories\Contracts\CourseRepositoryInterface;

class CourseService
{
    public function __construct(
        protected CourseRepositoryInterface $courseRepository
    ) {}

    public function list(Request $request)
    {
        $user = $request->user();

        $query = Course::query();

        // Guest or student → published only
        if (!$user || $user->hasRole('student')) {
            return $query->where('status', Course::STATUS_PUBLISHED);
        }

        // Instructor → own + published
        if ($user->hasRole('instructor')) {
            return $query->where(function ($q) use ($user) {
                $q->where('status', Course::STATUS_PUBLISHED)
                    ->orWhere('created_by', $user->id);
            });
        }

        // Admin → all
        if ($user->hasRole('admin')) {
            return $query;
        }

        return $query->where('status', Course::STATUS_PUBLISHED);
    }


    public function create(array $data): Course
    {
        $data['created_by'] = auth()->id();
        $data['status'] ??= Course::STATUS_DRAFT;

        return $this->courseRepository->create($data);
    }

    public function update(Course $course, array $data): Course
    {
        return $this->courseRepository->update($course, $data);
    }

    public function delete(Course $course): void
    {
        $this->courseRepository->delete($course);
    }

    public function publish(Course $course): Course
    {
        if ($course->status !== Course::STATUS_DRAFT) {
            throw ValidationException::withMessages([
                'status' => 'Only draft courses can be published',
            ]);
        }

        $course->update([
            'status' => Course::STATUS_PUBLISHED,
        ]);

        return $course;
    }
}
