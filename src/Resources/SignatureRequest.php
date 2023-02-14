<?php

namespace Assiclick\Yousign\Resources;

use Assiclick\Yousign\Http\Client;
use Illuminate\Http\Client\Response;

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
            $this->path.'/'.$this->id.'/activate',
            []
        );
    }

    /**
     * Cancel a signature request.
     *
     * @param  array  $params
     * @return array
     */
    public function cancel(array $params): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/cancel',
            $params
        );
    }

    /**
     * Reactivate an expired signature request.
     *
     * @param  array  $params
     * @return array
     */
    public function reactive(array $params): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/reactivate',
            $params
        );
    }

    /**
     * Download signature request audit trails.
     *
     * @return string
     */
    public function downloadAudit(): Response
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/audit_trails/download',
            [],
            'full',
        );
    }

    /**
     * List signature request documents.
     *
     * @param  array  $params
     * @return array
     */
    public function getDocuments(array $params = []): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/documents',
            $params
        );
    }

    /**
     * Get a document of Signature Request.
     *
     * @param  string  $documentId Document Id
     * @return array
     */
    public function getDocument(string $documentId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/documents/'.$documentId,
            []
        );
    }

    /**
     * Add a document to the Signature Request.
     *
     * @param  array  $data
     * @param  string  $attachment
     * @return array
     */
    public function addDocument(array $data, string $attachment): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/documents',
            $data,
            'json',
            $attachment
        );
    }

    /**
     * Delete a document of Signature Request.
     *
     * @param  string  $documentId Document Id
     * @return array
     */
    public function deleteDocument(string $documentId): array
    {
        return $this->client->request(
            'delete',
            $this->path.'/'.$this->id.'/documents/'.$documentId,
            []
        );
    }

    /**
     * Update a document.
     *
     * @param  array  $data
     * @return array
     */
    public function updateDocument(array $data): array
    {
        return $this->client->request(
            'patch',
            $this->path.'/'.$this->id,
            $this->parseObjArray($data)
        );
    }

    /**
     * Replace a document.
     *
     * @param  array  $data
     * @param  string  $attachment
     * @return array
     */
    public function replaceDocument(array $data, string $attachment): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/documents',
            $data,
            'json',
            $attachment
        );
    }

    /**
     * Download signature request documents.
     *
     * @param  string  $documentId Document Id
     * @return Response
     */
    public function downloadDocuments(array $data = []): Response
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/documents/download',
            $data,
            'full'
        );
    }

    /**
     * Create a new signer.
     *
     * @param  array  $data
     * @return array
     */
    public function createSigner(array $data): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/signers',
            $data
        );
    }

    /**
     * List signature request signers.
     *
     * @return array
     */
    public function getSigners(): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers',
            []
        );
    }

    /**
     * Get a signer.
     *
     * @param  string  $signerId
     * @return array
     */
    public function getSigner(string $signerId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers/'.$signerId,
            []
        );
    }

    /**
     * Delete a signer.
     *
     * @param  string  $signerId
     * @return array
     */
    public function deleteSigner(string $signerId): array
    {
        return $this->client->request(
            'delete',
            $this->path.'/'.$this->id.'/signers/'.$signerId,
            []
        );
    }

    /**
     * update a signer.
     *
     * @param  string  $signerId
     * @return array
     */
    public function updateSigner(string $signerId): array
    {
        return $this->client->request(
            'patch',
            $this->path.'/'.$this->id.'/signers/'.$signerId,
            []
        );
    }

    /**
     * Download audit trail PDF.
     *
     * @param  string  $signerId
     * @return array
     */
    public function downloadSignerAudit(string $signerId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers/'.$signerId.'/audit_trails/download',
            []
        );
    }

    /**
     * Get signer audit trail.
     *
     * @param  string  $signerId
     * @return array
     */
    public function getSignerAudit(string $signerId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers/'.$signerId.'/audit_trails',
            []
        );
    }
}
