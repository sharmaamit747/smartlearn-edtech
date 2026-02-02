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

    public function test_student_can_enroll_in_published_course(): void
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

    public function test_student_cannot_enroll_twice(): void
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

    public function test_student_cannot_enroll_in_draft_course(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);
        $course = Course::factory()->draft()->create();

        $this->postJson("/api/v1/enrollments/courses/{$course->id}")
            ->assertStatus(422);
    }

    public function test_instructor_cannot_enroll_in_own_course(): void
    {
        $instructor = $this->createUserWithRole('instructor');
        Sanctum::actingAs($instructor);
        $course = Course::factory()->published()->create([
            'created_by' => $instructor->id,
        ]);

        $this->postJson("/api/v1/enrollments/courses/{$course->id}")
            ->assertStatus(403);
    }

    public function test_student_can_cancel_own_enrollment(): void
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

    public function test_student_can_complete_enrollment(): void
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

    public function test_user_cannot_modify_others_enrollment(): void
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

    public function test_student_can_view_own_enrollments(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        Enrollment::factory()->count(3)->create([
            'user_id' => $student->id,
        ]);

        $this->getJson('/api/v1/enrollments/my')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_student_cannot_view_others_enrollments(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        Enrollment::factory()->create(); // other user

        $this->getJson('/api/v1/enrollments/my')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
