<?php

namespace NoviasNet\Yousign\Resources;

use NoviasNet\Yousign\Http\Client;

abstract class BaseResource
{
    protected Client $client;

    protected string $path;

    /**
     * Initialize Resource.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getList(string $url): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $url,
            []
        )['data'];
    }
}
