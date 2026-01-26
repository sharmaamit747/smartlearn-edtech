<?php

namespace Tests\Traits;

use Laravel\Sanctum\Sanctum;

trait ActsAsAdmin
{
    protected function actingAsAdmin(): void
    {
        $admin = $this->createUserWithRole('admin');
        Sanctum::actingAs($admin);
    }
}
