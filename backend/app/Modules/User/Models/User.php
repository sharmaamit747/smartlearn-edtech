<?php

namespace App\Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Modules\Shared\RBAC\Models\Role;
use App\Modules\Shared\RBAC\Models\Permission;
use Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, SoftDeletes;

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INACTIVE = 'INACTIVE';
    public const STATUS_BLOCKED = 'BLOCKED';

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

    protected $dates = ['deleted_at'];

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

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
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
