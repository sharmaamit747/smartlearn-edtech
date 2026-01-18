<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Modules\User\Models\User;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function unauthenticated_user_cannot_list_users(): void
    {
        $response = $this->getJson('/api/json');

        $response->assertStatus(401);
    }

    public function user_with_out_permission_cannot_list_users()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/users')
            ->assertStatus(403);
    }

    public function admin_can_list_users()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin'); // or equivalent

        User::factory()->count(3)->create();

        $this->actingAs($admin)
            ->getJson('/api/users')
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function per_page_is_capped_at_100()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        User::factory()->count(150)->create();

        $response = $this->actingAs($admin)
            ->getJson('/api/users?per_page=500');

        $this->assertLessThanOrEqual(
            100,
            count($response->json('data'))
        );
    }
}
