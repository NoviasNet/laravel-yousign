<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;
use Illuminate\Http\Client\Response;

class YousignTooManyRequestException extends YousignException
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
