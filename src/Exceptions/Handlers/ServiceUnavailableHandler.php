<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\YousignException;
use Assiclick\Yousign\Exceptions\YousignServiceUnavailableException;

class ServiceUnavailableHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(YousignException $exception, array $requestArguments)
    {
        throw new YousignServiceUnavailableException(
            $this->handleRetryAfter($exception),
            $exception->getResponse(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
