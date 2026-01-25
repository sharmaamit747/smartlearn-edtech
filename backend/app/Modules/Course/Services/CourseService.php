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
        return $this->courseRepository->paginate(
            filters: $request->only(['status', 'created_by', 'search']),
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
