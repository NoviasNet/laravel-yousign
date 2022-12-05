<?php

namespace Assiclick\Yousign\Resources;

use Assiclick\Yousign\Http\Client;

abstract class BaseResource
{
    /**
     * @var Client
     */
    protected Client $client;

    protected string $path;

    /**
     * Initialize Resource.
     *
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    protected function getList(string $url): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$url,
            []
        )['data'];
    }
}
