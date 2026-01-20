<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Shared\Exceptions\ApiException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * Exceptions that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * Inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render exceptions into HTTP responses.
     */
    public function render($request, Throwable $e): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        /**
         * 1️⃣ Custom API exception (your domain errors)
         */
        if ($e instanceof ApiException) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
                'code'    => $e->getStatus(),
            ], $e->getStatus());
        }

        /**
         * 2️⃣ Authentication error (401)
         */
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthenticated',
                'code'    => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }

        /**
         * 3️⃣ Validation error (422)
         */
        if ($e instanceof ValidationException) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
                'code'    => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /**
         * 4️⃣ HTTP exceptions (403, 404, etc.)
         */
        if ($e instanceof HttpExceptionInterface) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?: Response::$statusTexts[$e->getStatusCode()],
                'code'    => $e->getStatusCode(),
            ], $e->getStatusCode());
        }

        /**
         * 5️⃣ Fallback for API routes (500)
         */
        if ($request->is('api/*')) {
            return response()->json([
                'status'  => 'error',
                'message' => config('app.debug')
                    ? $e->getMessage()
                    : 'Internal Server Error',
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /**
         * 6️⃣ Non-API requests (default Laravel behavior)
         */
        return parent::render($request, $e);
    }
}
