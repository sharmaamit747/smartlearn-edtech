<?php

namespace App\Modules\Shared\RBAC\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug'];

    public function roles()
    {
        $this->belongsToMany(Role::class);
    }
}
