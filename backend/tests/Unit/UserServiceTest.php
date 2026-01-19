<?php

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\CreatesUsers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;
    /**
     * A basic unit test example.
     */
    public function test_user_is_created_with_hashed_password(): void
    {
        $service = app(\App\Modules\User\Services\UserService::class);

        $user = $service->create([
            'name' => 'Unit Test',
            'email' => 'unit@test.com',
            'password' => 'secret123',
        ]);

        $this->assertNotEquals('secret123', $user->password);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }
}
