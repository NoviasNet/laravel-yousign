<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;

class ApiInternalServerErrorException extends ApiException
{
    public function __construct($response, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($response, 'Internal Server Error', $httpCode, $previous);
    }
}
