<?php

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use NoviasNet\Yousign\Exceptions\SignerException;
use NoviasNet\Yousign\Http\Client;
use NoviasNet\Yousign\Resources\SignatureRequest;

it('constructor throws when apiKey is empty', function () {
    expect(fn () => new Client('', 'https://api.example.com'))
        ->toThrow(Exception::class, 'You need to pass API Key');
});

it('request sends a Bearer token', function () {
    Http::fake(['*' => Http::response(['id' => 'abc'], 200)]);

    $client = new Client('my-api-key', 'https://api.example.com');
    $client->request('get', 'signature_requests');

    Http::assertSent(function ($request) {
        return $request->hasHeader('Authorization', 'Bearer my-api-key');
    });
});

it('request builds the correct URL from base_url and path', function () {
    Http::fake(['*' => Http::response(['id' => 'abc'], 200)]);

    $client = new Client('key', 'https://api.example.com');
    $client->request('get', 'signature_requests');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://api.example.com/signature_requests';
    });
});

it('request returns json array by default', function () {
    Http::fake(['*' => Http::response(['id' => 'test-id', 'status' => 'draft'], 200)]);

    $client = new Client('key', 'https://api.example.com');
    $result = $client->request('get', 'signature_requests');

    expect($result)->toBe(['id' => 'test-id', 'status' => 'draft']);
});

it('request returns raw body when return is raw', function () {
    Http::fake(['*' => Http::response('raw-content', 200)]);

    $client = new Client('key', 'https://api.example.com');
    $result = $client->request('get', 'documents/download', [], 'raw');

    expect((string) $result)->toBe('raw-content');
});

it('request returns full response when return is full', function () {
    Http::fake(['*' => Http::response(['ok' => true], 200)]);

    $client = new Client('key', 'https://api.example.com');
    $result = $client->request('get', 'something', [], 'full');

    expect($result)->toBeInstanceOf(Response::class);
    expect($result->status())->toBe(200);
});

it('request on signer failure throws SignerException with human-readable message', function () {
    Http::fake([
        '*/signers' => Http::response([
            'type' => 'parameters_not_valid',
            'invalid_params' => [
                (object) ['name' => 'info[email]', 'reason' => 'This value is not a valid email address.'],
            ],
        ], 422),
    ]);

    $client = new Client('key', 'https://api.example.com');

    expect(fn () => $client->request('post', 'signature_requests/123/signers', []))
        ->toThrow(SignerException::class, 'Signer email');
});

it('request on non-signer failure propagates RequestException', function () {
    Http::fake(['*' => Http::response(['error' => 'not found'], 404)]);

    $client = new Client('key', 'https://api.example.com');

    expect(fn () => $client->request('get', 'signature_requests/missing', []))
        ->toThrow(RequestException::class);
});

it('updateSigner sends a PATCH request with data', function () {
    Http::fake([
        '*' => Http::response(['id' => 'signer-id', 'status' => 'initiated'], 200),
    ]);

    $client = new Client('test-api-key', 'https://api.example.com');
    $resource = new SignatureRequest($client, 'request-id');

    $result = $resource->updateSigner('signer-id', [
        'signature_level' => 'advanced_electronic_signature',
    ]);

    Http::assertSent(function ($request) {
        if ($request->method() !== 'PATCH') {
            return false;
        }

        if (! str_contains($request->url(), 'signers/signer-id')) {
            return false;
        }

        return $request['signature_level'] === 'advanced_electronic_signature';
    });

    expect($result)->toBeArray()->toHaveKey('id');
});

it('updateSigner sends a PATCH request without data', function () {
    Http::fake([
        '*' => Http::response(['id' => 'signer-id', 'status' => 'initiated'], 200),
    ]);

    $client = new Client('test-api-key', 'https://api.example.com');
    $resource = new SignatureRequest($client, 'request-id');

    $result = $resource->updateSigner('signer-id');

    Http::assertSent(function ($request) {
        if ($request->method() !== 'PATCH') {
            return false;
        }

        return str_contains($request->url(), 'signers/signer-id');
    });

    expect($result)->toBeArray()->toHaveKey('id');
});
