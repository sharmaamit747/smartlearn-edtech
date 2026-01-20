<?php

namespace App\Modules\Shared\RBAC\Middleware;

use App\Modules\Shared\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = $request->user();

        if (! $user || ! $user->hasPermission($permission)) {
            throw new ApiException(
                'You are not allowed to perform this action',
                Response::HTTP_FORBIDDEN
            );
        }

        return $next($request);
    }
}
