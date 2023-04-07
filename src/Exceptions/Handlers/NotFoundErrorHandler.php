<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\ApiEntityNotFoundException;
use Assiclick\Yousign\Exceptions\ApiException;

class NotFoundErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiEntityNotFoundException(
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
