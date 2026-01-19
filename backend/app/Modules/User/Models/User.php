<?php

namespace App\Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

use App\Modules\Shared\RBAC\Models\Role;
use App\Modules\Shared\RBAC\Models\Permission;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* -------------------------------------------------
     | Relationships
     |-------------------------------------------------*/

    // users ↔ role_user ↔ roles
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_user',
            'user_id',
            'role_id'
        );
    }

    // roles ↔ permission_role ↔ permissions (via roles)
    public function permissions()
    {
        return Permission::query()
            ->whereHas('roles', function ($q) {
                $q->whereIn('roles.id', $this->roles()->pluck('roles.id'));
            });
    }


    /* -------------------------------------------------
     | Authorization
     |-------------------------------------------------*/

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('slug', $permission);
            })
            ->exists();
    }

    /* -------------------------------------------------
     | Factory (Modules support)
     |-------------------------------------------------*/

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
