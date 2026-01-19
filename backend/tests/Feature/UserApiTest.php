<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\CreatesUsers;
use Tests\Traits\CreatesPermissions;
use Tests\Traits\ActsAsAdmin;

use App\Modules\Shared\RBAC\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    use CreatesPermissions;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Permission
        $permission = $this->createPermission('user.view');

        // Role WITH slug (required)
        $role = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin']
        );

        // Attach permission to role
        $role->permissions()->syncWithoutDetaching([$permission->id]);
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
}
