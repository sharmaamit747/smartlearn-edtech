<?php

namespace App\Modules\Shared\RBAC\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($permission)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
