<?php

namespace App\Modules\Course\Repositories;

use App\Modules\Course\Models\Course;
use App\Modules\Course\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepository implements CourseRepositoryInterface
{
    public function paginate(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = Course::query();

        // 🔓 Published only
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // 👨‍🏫 Instructor visibility:
        // own courses (any status) OR published
        if (!empty($filters['visible_to_instructor'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('created_by', $filters['visible_to_instructor'])
                    ->orWhere('status', Course::STATUS_PUBLISHED);
            });
        }

        // 🔍 Search
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);
        return $course->refresh();
    }

    public function delete(Course $course): void
    {
        $course->delete();
    }
}
