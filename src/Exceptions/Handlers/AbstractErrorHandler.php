<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Http\Client;
use Assiclick\Yousign\Exceptions\YousignException;

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
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return int
     */
    public function getMaxTries(): int
    {
        return $this->maxTries;
    }

    /**
     * @param int $maxTries
     *
     * @return AbstractErrorHandler
     */
    public function setMaxTries(int $maxTries): self
    {
        $this->maxTries = $maxTries;

        return $this;
    }

    /**
     * @param YousignException $exception
     * @param array        $requestArguments
     *
     * @return mixed
     *
     * @throws YousignException
     */
    abstract public function handle(YousignException $exception, array $requestArguments);
}
