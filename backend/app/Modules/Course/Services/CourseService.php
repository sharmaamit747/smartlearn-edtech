<?php

namespace App\Modules\Course\Services;

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
        $user = auth()->user();

        $filters = $request->only(['status', 'search']);

        // 🔓 Guest OR Student → published only
        if (!$user || $user->hasRole('student')) {
            $filters['status'] = Course::STATUS_PUBLISHED;
        }

        // 👨‍🏫 Instructor → own + published
        if ($user && $user->hasRole('instructor')) {
            $filters['visible_to_instructor'] = $user->id;
        }

        // 👑 Admin → no restriction
        if ($user && $user->hasRole('admin')) {
            // no filters added
        }

        return $this->courseRepository->paginate(
            filters: $filters,
            perPage: min($request->get('per_page', 15), 100)
        );
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
}
