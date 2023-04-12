<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\YousignException;
use Assiclick\Yousign\Exceptions\YousignForbiddenException;

class ForbiddenErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(YousignException $exception, array $requestArguments)
    {
        throw new YousignForbiddenException(
            $exception->getResponse(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
