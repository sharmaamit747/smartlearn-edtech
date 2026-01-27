<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Tests\Traits\ActsAsAdmin;
use App\Modules\Course\Models\Course;
use Tests\Traits\CreatesUsers;

class CoursePublishTest extends TestCase
{
    use CreatesUsers;
    use ActsAsAdmin;

    public function test_instructor_can_publish_own_draft_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        $course = Course::factory()->create([
            'status' => Course::STATUS_DRAFT,
            'created_by' => $instructor->id,
        ]);

        $this->postJson("/api/v1/courses/{$course->id}/publish")
            ->assertOk()
            ->assertJsonPath('data.status', Course::STATUS_PUBLISHED);
    }

    public function test_instructor_cannot_publish_others_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        $course = Course::factory()->create([
            'status' => Course::STATUS_DRAFT,
        ]);

        $this->postJson("/api/v1/courses/{$course->id}/publish")
            ->assertStatus(403);
    }

    public function test_instructor_cannot_publish_non_draft_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        $course = Course::factory()->published()->create([
            'created_by' => $instructor->id,
        ]);

        $this->postJson("/api/v1/courses/{$course->id}/publish")
            ->assertStatus(422);
    }

    public function test_admin_can_publish_any_course(): void
    {
        $this->actingAsAdmin();

        $course = Course::factory()->create([
            'status' => Course::STATUS_DRAFT,
        ]);

        $this->postJson("/api/v1/courses/{$course->id}/publish")
            ->assertOk();
    }

    public function test_student_cannot_publish_course(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        $course = Course::factory()->create();

        $this->postJson("/api/v1/courses/{$course->id}/publish")
            ->assertStatus(403);
    }
}
