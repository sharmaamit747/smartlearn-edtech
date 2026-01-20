<?php

namespace App\Modules\Shared\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ApiException extends Exception
{
    protected int $status;

    public function __construct(
        string $message,
        int $status = Response::HTTP_BAD_REQUEST
    ) {
        parent::__construct($message);
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
