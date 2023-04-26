<?php

namespace Assiclick\Yousign\Exceptions;

use Illuminate\Http\Client\Response;
use Throwable;

class YousignTooManyRequestException extends YousignException
{
    protected $secondRemaining;

    public function __construct(int $secondRemaining, Response $response, $message, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);

        $this->secondRemaining = $secondRemaining;
    }

    public function getSecondRemaining(): ?int
    {
        return $this->secondRemaining;
    }
}
