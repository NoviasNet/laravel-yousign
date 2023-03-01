<?php

namespace Assiclick\Yousign\Http;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Assiclick\Yousign\Exceptions\SignerException;

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
        $requestUrl = $this->baseUrl . '/' . $url;

        $http = Http::withToken($this->apiKey);

        if (! is_null($attachment)) {
            $http->attach(
                'file',
                file_get_contents($attachment),
                $data['file']
            );
        }

        $response = $http->{$method}($requestUrl, $data);

        if ($response->failed()) {
            if (Str::endsWith($url, '/signers')) {
                return $this->handleSignersExceptions($data, $response->object());
            }
        }

        if ($return === 'raw') {
            return $response->toPsrResponse()->getBody();
        }

        if ($return === 'full') {
            return $response->throw();
        }

        return $response->throw()->{$return}();
    }

    private function handleSignersExceptions(array $data, $response)
    {
        if ($response->type == 'parameters_not_valid') {
            $message = $this->handleErrorMessages($response->invalid_params);

            throw new SignerException($message);
        }
    }

    private function handleErrorMessages(array $params)
    {
        // dd($params);

        return collect($params)->map(function ($param) {
            return $this->convertErrorName($param->name) . ' - ' . $this->convertErrorReason($param->reason);
        })->implode(', ');
    }

    private function convertErrorName($name): ?string
    {
        if ($name == 'info[email]') {
            return 'Signer email';
        }

        if ($name == 'info[phone_number]') {
            return 'Signer phone number';
        }

        return null;
    }

    private function convertErrorReason($reason): ?string
    {
        if ($reason == 'This field is missing.') {
            return 'Missing mandatory field';
        }

        if ($reason == 'This value is not a valid email address.') {
            return 'Not valid';
        }

        if ($reason == 'This field is mandatory with this authentication mode (otp_sms).') {
            return 'Missing mandatory field';
        }

        if ($reason == 'This value is not a valid phone number.') {
            return 'Not valid';
        }

        return null;
    }
}
