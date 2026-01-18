<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function admin_can_list_users(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->getJson('/api/users')
            ->assertOk()
            ->asserJsonStructure(['data', 'links', 'meta']);
    }

    public function non_admin_cannot_list_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/users')
            ->assertForbidden();
    }
}
