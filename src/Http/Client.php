<?php

namespace Assiclick\Yousign\Http;

use Exception;
use Illuminate\Support\Facades\Http;

class Client
{
    /**
     * Auth constructor.
     *
     *
     * @throws Exception
     */
    public function __construct(private string $apiKey = '', private string $baseUrl = '', private string $brandingId = '')
    {
        if (empty($apiKey)) {
            throw new Exception('You need to pass API Key');
        }
    }

    /**
     * Exec API call.
     *
     * @return mixed
     */
    public function request(string $method = 'post', string $url = '', array $data = [], string $return = 'json', ?string $attachment = null)// : ?array
    {
        $requestUrl = $this->baseUrl.'/'.$url;

        $http = Http::withToken($this->apiKey);

        if (! is_null($attachment)) {
            $http->attach(
                'file',
                file_get_contents($attachment),
                $data['file']
            );
        }

        $response = $http->{$method}($requestUrl, $data);

        if ($return === 'raw') {
            return $response->toPsrResponse()->getBody();
        }

        if ($return === 'full') {
            return $response->throw();
        }

        return $response->throw()->{$return}();
    }
}
