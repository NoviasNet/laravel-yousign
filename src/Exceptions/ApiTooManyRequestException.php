<?php

namespace Assiclick\Yousign\Exceptions;

use Illuminate\Http\Client\Response;
use Throwable;

class ApiTooManyRequestException extends ApiException
{
    protected $rateLimit;

    public function __construct(array $rateLimit, Response $response, $message, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);

        $this->rateLimit = $rateLimit;
    }

    public function getRateLimit(): ?array
    {
        return $this->rateLimit;
    }
}
