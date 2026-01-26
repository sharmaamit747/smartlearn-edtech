<?php

namespace App\Modules\Shared\RBAC\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($permission)) {
            throw new \App\Modules\Shared\Exceptions\ApiException(
                'You are not allowed to perform this action',
                403
            );
        }

        return $next($request);
    }
}
