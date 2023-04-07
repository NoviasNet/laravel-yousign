<?php

namespace Assiclick\Yousign\Exceptions;

use Illuminate\Http\Client\Response;
use Throwable;

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
