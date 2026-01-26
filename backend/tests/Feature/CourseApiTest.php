<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\CreatesUsers;
use Tests\Traits\ActsAsAdmin;
use Laravel\Sanctum\Sanctum;
use App\Modules\Course\Models\Course;

class CourseApiTest extends TestCase
{
    use CreatesUsers;
    use ActsAsAdmin;

    /** @test */
    public function guest_can_list_only_published_courses(): void
    {
        Course::factory()->create(['status' => Course::STATUS_PUBLISHED]);
        Course::factory()->create(['status' => Course::STATUS_DRAFT]);

        $this->getJson('/api/v1/courses')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function student_can_list_only_published_courses(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        Course::factory()->create(['status' => Course::STATUS_PUBLISHED]);
        Course::factory()->create(['status' => Course::STATUS_DRAFT]);

        $this->getJson('/api/v1/courses')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function instructor_can_list_own_and_published_courses(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        Course::factory()->create([
            'status' => Course::STATUS_DRAFT,
            'created_by' => $instructor->id,
        ]);

        Course::factory()->create([
            'status' => Course::STATUS_PUBLISHED,
        ]);

        Course::factory()->create([
            'status' => Course::STATUS_DRAFT,
        ]);

        $this->getJson('/api/v1/courses')
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function admin_can_list_all_courses(): void
    {
        $this->actingAsAdmin();

        Course::factory()->count(3)->create();

        $this->getJson('/api/v1/courses')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function instructor_can_create_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        $this->postJson('/api/v1/courses', [
            'title' => 'Laravel Basics',
            'description' => 'Intro course',
        ])
            ->assertStatus(201)
            ->assertJsonPath('data.title', 'Laravel Basics');
    }

    /** @test */
    public function student_cannot_create_course(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        $this->postJson('/api/v1/courses', [
            'title' => 'Unauthorized Course',
        ])
            ->assertStatus(403);
    }

    /** @test */
    public function instructor_can_update_own_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        $course = Course::factory()->create([
            'created_by' => $instructor->id,
        ]);

        $this->putJson("/api/v1/courses/{$course->id}", [
            'title' => 'Updated Title',
        ])
            ->assertOk()
            ->assertJsonPath('data.title', 'Updated Title');
    }

    /** @test */
    public function instructor_cannot_update_others_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);

        $course = Course::factory()->create();

        $this->putJson("/api/v1/courses/{$course->id}", [
            'title' => 'Hack Attempt',
        ])
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_delete_any_course(): void
    {
        $this->actingAsAdmin();

        $course = Course::factory()->create();

        $this->deleteJson("/api/v1/courses/{$course->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Course deleted successfully',
            ]);

        $this->assertSoftDeleted('courses', [
            'id' => $course->id,
        ]);
    }
}
