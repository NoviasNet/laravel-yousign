<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\ApiException;
use Assiclick\Yousign\Exceptions\ApiInternalServerErrorException;

class InternalServerErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        throw new ApiInternalServerErrorException(
            $exception->getResponse(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
