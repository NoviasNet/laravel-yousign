<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;

class YousignUnauthorizedException extends YousignException
{
    public function __construct($response, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, 'Unauthorized', $httpCode, $previous);
    }
}
