<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\YousignException;
use Assiclick\Yousign\Exceptions\YousignTooManyRequestException;

/**
 * Class TooManyRequestErrorHandler.
 */
class TooManyRequestErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(YousignException $exception, array $requestArguments)
    {
        throw new YousignTooManyRequestException(
            $this->handleRetryAfter($exception),
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
