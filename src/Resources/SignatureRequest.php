<?php

namespace Assiclick\Yousign\Resources;

use Assiclick\Yousign\Http\Client;

class SignatureRequest extends Resource
{
    protected string $path = 'signature_requests';

    /**
     * Initialize Resource.
     *
     * @param  Client  $client
     */
    public function __construct(Client $client, string $id = '')
    {
        parent::__construct($client, $id);
    }

    /**
     * Activate a signature request.
     *
     * @return array
     */
    public function activate(): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $this->id . '/activate',
            []
        );
    }

    /**
     * Cancel a signature request.
     *
     * @param  int   $id Signature request Id
     * @return array
     */
    public function cancel(array $params = []): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $this->id . '/activate',
            $params
        );
    }

    /**
     * Reactivate an expired signature request.
     *
     * @param  int   $id Signature request Id
     * @return array
     */
    public function reactive(array $params = []): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $this->id . '/activate',
            $params
        );
    }

    /**
     * Download signature request audit trails.
     *
     * @param  string   $id Signature request Id
     * @return array
     */
    public function downloadAudit(): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $this->id . '/audit_trails/download',
            []
        );
    }

    /**
     * List signature request documents.
     *
     * @param  array $params
     * @return array
     */
    public function getDocuments(array $params = []): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $this->id . '/documents',
            $params
        );
    }

    /**
     * Get a document of Signature Request.
     *
     * @param  string    $documentId         Document Id
     * @return array
     */
    public function getDocument(string $documentId): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $this->id . '/documents' . $documentId,
            []
        );
    }

    /**
     * Add a document to the Signature Request.
     *
     * @param  int    $documentId         Document Id
     * @return array
     */
    public function addDocument(array $data, string $attachment): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $this->id . '/documents',
            $data,
            $attachment
        );
    }
}
