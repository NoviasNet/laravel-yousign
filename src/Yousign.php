<?php

namespace Assiclick\Yousign;

use Exception;
use Assiclick\Yousign\Http\Client;
use Assiclick\Yousign\Resources\BaseResource;

class Yousign
{
    protected Client $client;

    /**
     * Yousign constructor.
     *
     * @throws Exception
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Return an instance of a Resource based on the method called.
     *
     * @param mixed $args
     */
    public function __call(string $name, $args): BaseResource
    {
        $resource = 'Assiclick\\Yousign\\Resources\\' . ucfirst($name);

        /* @var BaseResource */
        return new $resource($this->client, ...$args);
    }
}
