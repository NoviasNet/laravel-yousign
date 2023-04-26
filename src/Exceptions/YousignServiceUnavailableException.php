<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;
use Illuminate\Http\Client\Response;

class YousignServiceUnavailableException extends YousignException
{
    protected $secondRemaining;

    public function __construct(int $secondRemaining, Response $response, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, 'Service Unavailable', $httpCode, $previous);

        $this->secondRemaining = $secondRemaining;
    }

    public function getSecondRemaining(): ?int
    {
        return $this->secondRemaining;
    }
}
