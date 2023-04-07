<?php

namespace Assiclick\Yousign\Http;

interface ClientInterface
{
    /**
     * Create a request and return the raw response.
     *
     * @param  string  $method
     * @return mixed
     */
    public function rawRequest($endpoint, array $data = [], $method = 'get');

    /**
     * Call rawRequest and handle the result.
     *
     * @param  string  $method
     * @return mixed
     */
    public function request($endpoint, array $data = [], $method = 'get');

    public function getResponseHeaders(): array;
}
