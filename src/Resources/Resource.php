<?php

namespace Assiclick\Yousign\Resources;

use Assiclick\Yousign\Http\Client;

abstract class Resource extends BaseResource
{
    /**
     * Initialize Resource.
     *
     * @param Client $client
     */
    public function __construct(Client $client, protected string $id = '')
    {
        parent::__construct($client);
    }

    public function all(array $params = []): array
    {
        return $this->client->request(
            'get',
            $this->path,
            $params
        );
    }

    public function create(array $data): array
    {
        return $this->client->request(
            'post',
            $this->path,
            $this->parseObjArray($data)
        );
    }

    public function update(array $data): array
    {
        return $this->client->request(
            'patch',
            $this->path . '/' . $this->id,
            $this->parseObjArray($data)
        );
    }

    public function delete(): ?array
    {
        return $this->client->request(
            'delete',
            $this->path . '/' . $this->id,
            []
        );
    }

    public function fetch(): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $this->id,
            []
        );
    }

    protected function parseObjArray(array $params): array
    {
        return $params;
    }
}
