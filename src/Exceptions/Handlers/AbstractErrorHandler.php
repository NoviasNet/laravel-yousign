<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\ApiException;
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
     * @throws ApiException
     */
    abstract public function handle(ApiException $exception, array $requestArguments);
}
