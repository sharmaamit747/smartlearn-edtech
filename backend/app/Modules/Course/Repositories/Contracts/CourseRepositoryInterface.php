<?php

namespace App\Modules\Course\Repositories\Contracts;

use App\Modules\Course\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function paginate(array $filters, int $perPage): LengthAwarePaginator;
    public function create(array $data): Course;
    public function update(Course $course, array $data): Course;
    public function delete(Course $course): void;
}
