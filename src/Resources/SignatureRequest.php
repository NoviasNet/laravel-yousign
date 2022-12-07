<?php

namespace Assiclick\Yousign\Resources;

class SignatureRequest extends Resource
{
    protected string $path = 'signature_requests';

    /**
     * Activate a signature request.
     *
     * @param  int   $id Signature request Id
     * @return array
     */
    public function activate(int $id): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $id . '/activate',
            []
        )['data'];
    }

    /**
     * Cancel a signature request.
     *
     * @param  int   $id Signature request Id
     * @return array
     */
    public function cancel(int $id, array $params = []): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $id . '/activate',
            $params
        )['data'];
    }

    /**
     * Reactivate an expired signature request.
     *
     * @param  int   $id Signature request Id
     * @return array
     */
    public function reactive(int $id, array $params = []): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $id . '/activate',
            $params
        )['data'];
    }

    /**
     * Download signature request audit trails.
     *
     * @param  int   $id Signature request Id
     * @return array
     */
    public function downloadAudit(int $id): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $id . '/activate',
            []
        );
    }

    /**
     * List signature request documents.
     *
     * @param  int   $id     Signature request Id
     * @param  array $params
     * @return array
     */
    public function getDocuments(int $id, array $params = []): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $id . '/documents',
            $params
        )['data'];
    }

    /**
     * Get a document.
     *
     * @param  int   $signatureRequestId Signature request Id
     * @param  int   $documentId         Document Id
     * @return array
     */
    public function getDocument(int $signatureRequestId, int $documentId): array
    {
        return $this->client->request(
            'get',
            $this->path . '/' . $signatureRequestId . '/documents' . $documentId,
            []
        )['data'];
    }

    /**
     * Get a document.
     *
     * @param  int   $signatureRequestId Signature request Id
     * @param  int   $documentId         Document Id
     * @return array
     */
    public function addDocument(int $signatureRequestId, array $data): array
    {
        return $this->client->request(
            'post',
            $this->path . '/' . $signatureRequestId . '/documents',
            $data
        )['data'];
    }
}
