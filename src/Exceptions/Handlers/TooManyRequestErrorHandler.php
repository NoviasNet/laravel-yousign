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
            $this->handleRateLimit($exception),
            $exception->getResponse(),
            $exception->getMessage(),
            $exception->getCode(),
            $exception->getPrevious()
        );
    }

    protected function handleRateLimit(YousignException $exception)
    {
        $response = $exception->getResponse();

        return [
            'limitHour' => (int) $response->getHeader('x-ratelimit-limit-hour')[0],
            'limitMinute' => (int) $response->getHeader('x-ratelimit-limit-minute')[0],
            'remaingHour' => (int) $response->getHeader('x-ratelimit-remaining-hour')[0],
            'remaingMinute' => (int) $response->getHeader('x-ratelimit-remaining-minute')[0],
        ];
    }
}
