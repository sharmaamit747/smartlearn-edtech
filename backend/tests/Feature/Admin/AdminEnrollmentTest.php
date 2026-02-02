<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Tests\Traits\CreatesUsers;
use App\Modules\Enrollment\Models\Enrollment;

class AdminEnrollmentTest extends TestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_admin_can_view_all_enrollments(): void
    {
        $admin = $this->createUserWithRole('admin');
        Sanctum::actingAs($admin);

        Enrollment::factory()->count(5)->create();

        $this->getJson('/api/v1/admin/enrollments')
            ->assertOk()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data',
                    'current_page',
                    'total',
                ],
            ]);
    }

    public function test_non_admin_cannot_view_all_enrollments(): void
    {
        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        Enrollment::factory()->count(3)->create();

        $this->getJson('/api/v1/admin/enrollments')
            ->assertStatus(403);
    }

    public function test_admin_can_filter_enrollments_by_course(): void
    {
        $admin = $this->createUserWithRole('admin');
        Sanctum::actingAs($admin);

        // ✅ Create ONE course explicitly
        $course = \App\Modules\Course\Models\Course::factory()->create();

        // ✅ Ensure BOTH enrollments belong to SAME course
        Enrollment::factory()->count(2)->create([
            'course_id' => $course->id,
        ]);

        // Other courses enrollments
        Enrollment::factory()->count(3)->create();

        $this->getJson("/api/v1/admin/enrollments?course_id={$course->id}")
            ->assertOk()
            ->assertJsonPath('data.total', 2);
    }


    public function test_admin_can_filter_enrollments_by_user(): void
    {
        $admin = $this->createUserWithRole('admin');
        Sanctum::actingAs($admin);

        $student = $this->createUserWithRole('student');

        Enrollment::factory()->count(2)->create([
            'user_id' => $student->id,
        ]);

        Enrollment::factory()->count(3)->create(); // other users

        $this->getJson("/api/v1/admin/enrollments?user_id={$student->id}")
            ->assertOk()
            ->assertJsonPath('data.total', 2);
    }

    public function test_admin_can_filter_enrollments_by_status(): void
    {
        $admin = $this->createUserWithRole('admin');
        Sanctum::actingAs($admin);

        Enrollment::factory()->count(2)->create([
            'status' => Enrollment::STATUS_ACTIVE,
        ]);

        Enrollment::factory()->count(3)->create([
            'status' => Enrollment::STATUS_CANCELLED,
        ]);

        $this->getJson('/api/v1/admin/enrollments?status=' . Enrollment::STATUS_ACTIVE)
            ->assertOk()
            ->assertJsonPath('data.total', 2);
    }
}
