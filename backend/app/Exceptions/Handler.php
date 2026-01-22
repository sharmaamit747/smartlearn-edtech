<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Modules\Shared\Exceptions\ApiException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    protected function shouldReturnJson($request, Throwable $e): bool
    {
        return $request->is('api/*');
    }

    public function register(): void
    {
        // ✅ ApiException (RBAC, domain rules)
        $this->renderable(function (ApiException $e, $request) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'code'    => $e->getStatus(),
            ], $e->getStatus());
        });

        // ✅ Authentication
        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated',
                'code'    => 401,
            ], 401);
        });

        // ✅ Validation
        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
                'code'    => 422,
            ], 422);
        });

        // ✅ HTTP exceptions (403, 404, etc.)
        $this->renderable(function (HttpExceptionInterface $e, $request) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?: 'Forbidden',
                'code'    => $e->getStatusCode(),
            ], $e->getStatusCode());
        });
    }
}
