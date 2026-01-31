<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Enrollment\Models\Enrollment;
use App\Modules\User\Models\User;
use App\Modules\Course\Models\Course;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'status' => Enrollment::STATUS_ACTIVE,
        ];
    }

    public function completed(): self
    {
        return $this->state([
            'status' => Enrollment::STATUS_COMPLETED,
        ]);
    }

    public function cancelled(): self
    {
        return $this->state([
            'status' => Enrollment::STATUS_CANCELLED,
        ]);
    }

    public function draft(): self
    {
        return $this->state([
            'status' => Course::STATUS_DRAFT,
        ]);
    }
}
