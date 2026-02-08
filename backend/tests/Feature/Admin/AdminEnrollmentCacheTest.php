<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Tests\Traits\CreatesUsers;
use Illuminate\Support\Facades\Cache;
use App\Modules\Enrollment\Models\Enrollment;

class AdminEnrollmentCacheTest extends TestCase
{
    use CreatesUsers;

    public function test_cache_is_cleared_when_enrollment_is_created(): void
    {
        Cache::tags(['admin_enrollments'])->put('test_key', 'cached', 300);

        $this->assertTrue(
            Cache::tags(['admin_enrollments'])->has('test_key')
        );

        $student = $this->createUserWithRole('student');
        Sanctum::actingAs($student);

        Enrollment::factory()->create([
            'user_id' => $student->id,
        ]);

        $this->assertFalse(
            Cache::tags(['admin_enrollments'])->has('test_key')
        );
    }
}
