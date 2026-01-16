<?php

namespace App\Modules\Shared\RBAC\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Shared\Exceptions\ApiException;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, string $permission)
    {
        $user = auth()->user();

        if (!$user || !$user->hasPermission($permission)) {
            throw new ApiException('Unauthorized', 403);
        }

        return $next($request);
    }
}
