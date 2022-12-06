<?php

namespace Assiclick\Yousign\Resources;

abstract class Resource extends BaseResource
{
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
        )['data'];
    }

    public function update(int $id, array $data): array
    {
        return $this->client->request(
            'patch',
            $this->path.'/'.$id,
            $this->parseObjArray($data)
        )['data'];
    }

    public function delete(int $id, array $params = []): array
    {
        return $this->client->request(
            'delete',
            $this->path.'/'.$id,
            $params
        );
    }

    public function getById(int $id, array $params = []): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$id,
            $params
        )['data'];
    }

    protected function parseObjArray(array $params): array
    {
        return $params;
    }
}
