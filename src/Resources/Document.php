<?php

namespace Assiclick\Yousign\Resources;

class Document
{
    protected string $path = 'documents';

    /**
     * Upload a document.
     *
     * @param  array  $data
     * @return array
     */
    public function upload(array $data): array
    {
        return $this->client->request(
            'post',
            $this->path,
            $this->parseObjArray($data)
        )['data'];
    }

    protected function parseObjArray(array $params): array
    {
        return $params;
    }
}
