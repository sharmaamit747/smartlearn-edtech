<?php

namespace App\Modules\Shared\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception
{
    protected int $statusCode;

    public function __construct(string $message = "", $statusCode = 400, Throwable|null $previous = null)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
