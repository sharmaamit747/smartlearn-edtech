<?php

namespace App\Modules\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Shared\Exceptions\ApiException;
use App\Modules\User\Models\User;

class EnsureActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Not authenticated → let auth middleware handle it
        if (!$user) {
            return $next($request);
        }

        if ($user->status !== User::STATUS_ACTIVE) {
            throw new ApiException(
                'Your account is not active',
                403
            );
        }

        return $next($request);
    }
}
