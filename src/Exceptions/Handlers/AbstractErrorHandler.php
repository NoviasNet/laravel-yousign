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
}
