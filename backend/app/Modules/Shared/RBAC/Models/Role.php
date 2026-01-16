<?php

namespace App\Modules\Shared\RBAC\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\User;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
