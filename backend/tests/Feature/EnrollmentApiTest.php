<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Modules\User\Models\User;
use Tests\Traits\ActsAsAdmin;
use Laravel\Sanctum\Sanctum;
use App\Modules\Course\Models\Course;
use Tests\Traits\CreatesUsers;
use App\Modules\Enrollment\Models\Enrollment;

class EnrollmentApiTest extends TestCase
{
    use CreatesUsers;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function student_can_enroll_in_published_course(): void
    {
        $student = $this->createUserWithRole('student');
        $instructor = $this->createUserWithRole('instructor');

        $course = Course::factory()->create([
            'status' => Course::STATUS_PUBLISHED,
            'created_by' => $instructor->id,
        ]);

        Sanctum::actingAs($student); // ✅ ONLY student

        $this->postJson("/api/v1/enrollments/courses/{$course->id}")
            ->assertStatus(201)
            ->assertJsonPath('data.course_id', $course->id)
            ->assertJsonPath('data.status', Enrollment::STATUS_ACTIVE);
    }


    /** @test */
    public function student_cannot_enroll_twice(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);
        $course = Course::factory()->published()->create();

        Enrollment::factory()->create([
            'course_id' => $course->id,
            'user_id' => $student->id,
        ]);

        $this->postJson("/api/v1/enrollments/courses/{$course->id}")
            ->assertStatus(422);
    }

    /** @test */
    public function student_cannot_enroll_in_draft_course(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);
        $course = Course::factory()->draft()->create();

        $this->postJson("/api/v1/enrollments/courses/{$course->id}")
            ->assertStatus(422);
    }

    /** @test */
    public function instructor_cannot_enroll_in_own_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);
        $course = Course::factory()->published()->create([
            'created_by' => $instructor->id,
        ]);

        $this->postJson("/api/v1/enrollments/courses/{$course->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function student_can_cancel_own_enrollment(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);
        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
        ]);

        $this->postJson("/api/v1/enrollments/{$enrollment->id}/cancel")
            ->assertOk()
            ->assertJsonPath('data.status', Enrollment::STATUS_CANCELLED);
    }

    /** @test */
    public function student_can_complete_enrollment(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);
        $enrollment = Enrollment::factory()->create([
            'user_id' => $student->id,
            'status' => Enrollment::STATUS_ACTIVE,
        ]);

        $this->postJson("/api/v1/enrollments/{$enrollment->id}/complete")
            ->assertOk()
            ->assertJsonPath('data.status', Enrollment::STATUS_COMPLETED);
    }

    /** @test */
    public function user_cannot_modify_others_enrollment(): void
    {
        $owner = $this->createUserWithRole('student');
        $attacker = $this->createUserWithRole('student');

        $enrollment = Enrollment::factory()->create([
            'user_id' => $owner->id, // ✅ belongs to someone else
        ]);

        Sanctum::actingAs($attacker); // ✅ different user

        $this->postJson("/api/v1/enrollments/{$enrollment->id}/cancel")
            ->assertStatus(403);
    }
}
