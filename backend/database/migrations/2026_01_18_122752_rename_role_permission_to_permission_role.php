<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('role_permission') && ! Schema::hasTable('permission_role')) {
            Schema::rename('role_permission', 'permission_role');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('permission_role')) {
            Schema::rename('permission_role', 'role_permission');
        }
    }
};
