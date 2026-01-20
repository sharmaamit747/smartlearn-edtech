<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\CreatesUsers;
use Tests\Traits\ActsAsAdmin;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use CreatesUsers;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_unauthenticated_user_cannot_list_users(): void
    {
        $this->getJson('/api/v1/users/')
            ->assertStatus(401);
    }

    public function test_user_without_permission_cannot_list_users(): void
    {
        $user = $this->createUser();

        Sanctum::actingAs($user);

        $this->getJson('/api/v1/users/')
            ->assertStatus(403);
    }

    public function test_admin_can_list_users(): void
    {
        $this->actingAsAdmin();

        $this->getJson('/api/v1/users/')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta',
            ]);
    }

    public function test_per_page_is_capped_at_100(): void
    {
        $this->actingAsAdmin();

        $this->getJson('/api/v1/users?per_page=500')
            ->assertStatus(200)
            ->assertJsonPath('meta.per_page', 100);
    }

    public function test_admin_can_create_user(): void
    {
        $this->actingAsAdmin();

        $payload = [
            'name' => 'Test User 1',
            'email' => 'test2@example.com',
            'password' => 'password123',
        ];

        $this->postJson('/api/v1/users', $payload)
            ->assertStatus(201)
            ->assertJsonPath('data.email', 'test2@example.com');
    }


    public function test_admin_can_update_user()
    {
        $this->actingAsAdmin();
        $user = $this->createUser();

        $this->putJson("/api/v1/users/{$user->id}", [
            'name' => 'Updated Name',
        ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Updated Name');
    }



    public function test_student_can_update_self()
    {
        $user = $this->createUserWithRole('student');

        $this->actingAs($user)
            ->putJson("/api/v1/users/{$user->id}/self", [
                'name' => 'My Name',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'My Name');
    }

    public function test_instructor_can_update_self()
    {
        $user = $this->createUserWithRole('instructor');

        $this->actingAs($user)
            ->putJson("/api/v1/users/{$user->id}/self", [
                'name' => 'My Name',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'My Name');
    }
}
