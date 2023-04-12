<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\YousignException;
use Assiclick\Yousign\Exceptions\YousignUnauthorizedException;

class UnauthorizedErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(YousignException $exception, array $requestArguments)
    {
        throw new YousignUnauthorizedException(
            $exception->getResponse(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
