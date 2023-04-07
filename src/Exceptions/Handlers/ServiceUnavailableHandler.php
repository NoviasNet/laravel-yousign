<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\ApiException;
use Assiclick\Yousign\Exceptions\ApiServiceUnavailableException;

class ServiceUnavailableHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiServiceUnavailableException(
            $exception->getResponse(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
