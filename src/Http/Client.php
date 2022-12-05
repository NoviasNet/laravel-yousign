<?php

namespace Assiclick\Yousign\Http;

use Illuminate\Support\Facades\Http;

class Client
{
    /**
     * Auth constructor.
     *
     * @param  string  $apiKey
     * @param  string  $baseUrl
     * @param  string  $brandingId
     *
     * @throws \Exception
     */
    public function __construct(private readonly string $apiKey = '', private readonly string $baseUrl = '',  private readonly string $brandingId = '',)
    {
        if (empty($apiKey)) {
            throw new \Exception('You need to pass API Key');
        }
    }

    /**
     * Exec API call.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  array  $data
     * @param  bool  $forceUrl
     * @return array
     */
    public function request(string $method = 'post', string $url = '', array $data = []): array
    {
        $requestUrl = $this->baseUrl . '/' . $url;

        $response = Http::withToken($this->apiKey)->$method($requestUrl, $data);

        return $response->throw()->json();
    }
}