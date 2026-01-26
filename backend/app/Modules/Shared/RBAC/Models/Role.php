<?php

namespace App\Modules\Shared\RBAC\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // roles ↔ role_user ↔ users
    public function users()
    {
        return $this->belongsToMany(
            \App\Modules\User\Models\User::class,
            'role_user',
            'role_id',
            'user_id'
        );
    }

    // roles ↔ permission_role ↔ permissions
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_role',
            'role_id',
            'permission_id'
        );
    }
}
