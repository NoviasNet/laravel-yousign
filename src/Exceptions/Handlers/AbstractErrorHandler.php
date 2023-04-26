<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\YousignException;
use Assiclick\Yousign\Http\Client;

/**
 * Class AbstractErrorHandler.
 */
abstract class AbstractErrorHandler
{
    /**
     * @var int
     */
    public $tries = 0;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var int
     */
    protected $maxTries = 3;

    /**
     * AbstractErrorHandler constructor.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getMaxTries(): int
    {
        return $this->maxTries;
    }

    public function setMaxTries(int $maxTries): self
    {
        $this->maxTries = $maxTries;

        return $this;
    }

    /**
     * @return mixed
     *
     * @throws YousignException
     */
    abstract public function handle(YousignException $exception, array $requestArguments);

    protected function handleRetryAfter(YousignException $exception): int
    {
        $retyAfter = $exception
            ->getResponse()
            ->getHeader('Retry-After');

        if (! is_null($retyAfter)) {
            return $retyAfter;
        }

        $rateLimit = $this->handleRateLimit($exception);

        if ($rateLimit['remaingHour'] === 0) {
            return 3600;
        }

        return 60;
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
