<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;

class ApiServiceUnavailableException extends ApiException
{
    public function __construct($response, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, 'Service Unavailable', $httpCode, $previous);
    }
}
