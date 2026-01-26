<?php

namespace App\Modules\Shared\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    public function __construct(
        string $message,
        int $status = 400,
        array $headers = []
    ) {
        parent::__construct($status, $message, null, $headers);
    }
}
