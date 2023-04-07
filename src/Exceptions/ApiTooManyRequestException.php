<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;
use Illuminate\Http\Client\Response;

class ApiTooManyRequestException extends ApiException
{
    protected $rateLimit;

    public function __construct(array $rateLimit, Response $response, $message, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);

        dd($rateLimit);

        $this->rateLimit = $rateLimit;
    }

    public function getRateLimit(): ?array
    {
        return $this->rateLimit;
    }
}
