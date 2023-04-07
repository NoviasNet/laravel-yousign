<?php

namespace Assiclick\Yousign\Exceptions;

use Throwable;
use Illuminate\Http\Client\Response;

class ApiEntityNotFoundException extends ApiException
{
    public function __construct(Response $response, $message = null, $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $response,
            $message ?? 'Entity not found',
            $httpCode,
            $previous
        );
    }
}
