<?php

namespace NoviasNet\Yousign\Resources;

use Illuminate\Http\Client\Response;
use NoviasNet\Yousign\DataObjects\CreateSignatureRequest;

class SignatureRequest extends Resource
{
    protected string $path = 'signature_requests';

    public function create(CreateSignatureRequest|array $data): array
    {
        $payload = $data instanceof CreateSignatureRequest
            ? $data->toArray()
            : $data;

        return parent::create($payload);
    }

    /** Activate a signature request. */
    public function activate(): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/activate',
            []
        );
    }

    /** Cancel a signature request. */
    public function cancel(array $params): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/cancel',
            $params
        );
    }

    /** Reactivate an expired signature request. */
    public function reactive(array $params): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/reactivate',
            $params
        );
    }

    /** Download signature request audit trails. */
    public function downloadAudit(): Response
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/audit_trails/download',
            [],
            'full',
        );
    }

    /** List signature request documents. */
    public function getDocuments(array $params = []): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/documents',
            $params
        );
    }

    /** Get a document of Signature Request. */
    public function getDocument(string $documentId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/documents/'.$documentId,
            []
        );
    }

    /** Add a document to the Signature Request. */
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

    /** Delete a document of Signature Request. */
    public function deleteDocument(string $documentId): array
    {
        return $this->client->request(
            'delete',
            $this->path.'/'.$this->id.'/documents/'.$documentId,
            []
        );
    }

    /** Update a document. */
    public function updateDocument(array $data): array
    {
        return $this->client->request(
            'patch',
            $this->path.'/'.$this->id,
            $this->parseObjArray($data)
        );
    }

    /** Replace a document. */
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

    /** Download signature request documents. */
    public function downloadDocuments(array $data = []): Response
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/documents/download',
            $data,
            'full'
        );
    }

    /** Create a new signer. */
    public function createSigner(array $data): array
    {
        return $this->client->request(
            'post',
            $this->path.'/'.$this->id.'/signers',
            $data
        );
    }

    /** List signature request signers. */
    public function getSigners(): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers',
            []
        );
    }

    /** Get a signer. */
    public function getSigner(string $signerId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers/'.$signerId,
            []
        );
    }

    /** Delete a signer. */
    public function deleteSigner(string $signerId): array
    {
        return $this->client->request(
            'delete',
            $this->path.'/'.$this->id.'/signers/'.$signerId,
            []
        );
    }

    /** Update a signer. */
    public function updateSigner(string $signerId, array $data = []): array
    {
        return $this->client->request(
            'patch',
            $this->path.'/'.$this->id.'/signers/'.$signerId,
            $data
        );
    }

    /** Download audit trail PDF. */
    public function downloadSignerAudit(string $signerId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers/'.$signerId.'/audit_trails/download',
            []
        );
    }

    /** Get signer audit trail. */
    public function getSignerAudit(string $signerId): array
    {
        return $this->client->request(
            'get',
            $this->path.'/'.$this->id.'/signers/'.$signerId.'/audit_trails',
            []
        );
    }
}
