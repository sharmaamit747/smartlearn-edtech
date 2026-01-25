<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Modules\Course\Models\Course;
use App\Modules\User\Models\User;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'status' => Course::STATUS_DRAFT,
            'created_by' => User::factory(),
        ];
    }

    public function published(): self
    {
        return $this->state(fn() => [
            'status' => Course::STATUS_PUBLISHED,
        ]);
    }

    public function archived(): self
    {
        return $this->state(fn() => [
            'status' => Course::STATUS_ARCHIVED,
        ]);
    }
}
