<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;

class YousignBadRequestException extends YousignException
{
    public function __construct($response, $message, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, $message, $httpCode, $previous);
    }
}
