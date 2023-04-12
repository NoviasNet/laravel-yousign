<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\YousignException;
use Assiclick\Yousign\Exceptions\YousignInternalServerErrorException;

class InternalServerErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(YousignException $exception, array $requestArguments)
    {
        throw new YousignInternalServerErrorException(
            $exception->getResponse(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
