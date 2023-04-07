<?php

namespace Assiclick\Yousign\Http;

use Assiclick\Yousign\Exceptions\ApiException;
use Assiclick\Yousign\Exceptions\Handlers\AbstractErrorHandler;
use Assiclick\Yousign\Exceptions\Handlers\BadRequestErrorHandler;
use Assiclick\Yousign\Exceptions\Handlers\ForbiddenErrorHandler;
use Assiclick\Yousign\Exceptions\Handlers\InternalServerErrorHandler;
use Assiclick\Yousign\Exceptions\Handlers\NotFoundErrorHandler;
use Assiclick\Yousign\Exceptions\Handlers\ServiceUnavailableHandler;
use Assiclick\Yousign\Exceptions\Handlers\TooManyRequestErrorHandler;
use Assiclick\Yousign\Exceptions\Handlers\UnauthorizedErrorHandler;
use Assiclick\Yousign\Exceptions\SignerException;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Client
{
    const HTTP_NETWORK_ERROR_CODE = 0;

    const HTTP_BAD_REQUEST = 400;

    const HTTP_UNAUTHORIZED = 401;

    const HTTP_FORBIDDEN = 403;

    const HTTP_NOT_FOUND_ERROR_CODE = 404;

    const HTTP_TOO_MANY_REQUEST = 429;

    const HTTP_INTERNAL_SERVER_ERROR = 500;

    const HTTP_SERVICE_UNAVAILABLE = 503;

    /**
     * @var AbstractErrorHandler[]
     */
    protected $errorHandlers = [];

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

        $this->setErrorHandler(self::HTTP_UNAUTHORIZED, new UnauthorizedErrorHandler($this));
        $this->setErrorHandler(self::HTTP_FORBIDDEN, new ForbiddenErrorHandler($this));
        $this->setErrorHandler(self::HTTP_NOT_FOUND_ERROR_CODE, new NotFoundErrorHandler($this));
        $this->setErrorHandler(self::HTTP_BAD_REQUEST, new BadRequestErrorHandler($this));
        $this->setErrorHandler(self::HTTP_TOO_MANY_REQUEST, new TooManyRequestErrorHandler($this));
        $this->setErrorHandler(self::HTTP_INTERNAL_SERVER_ERROR, new InternalServerErrorHandler($this));
        $this->setErrorHandler(self::HTTP_SERVICE_UNAVAILABLE, new ServiceUnavailableHandler($this));
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

        if ($response->successful()) {
            if ($return === 'raw') {
                return $response->toPsrResponse()->getBody();
            }

            if ($return === 'full') {
                return $response;
            }

            return $response->{$return}();
        }

        if ($response->failed()) {
            return $this->handleFailedRequest($response, $method, $url, $data);
        }
    }

    /**
     * Define or remove an error handler for the request.
     * Pass null to remove an existing handler.
     *
     *
     * @return $this
     */
    public function setErrorHandler(int $code, ?AbstractErrorHandler $handler)
    {
        $this->errorHandlers[$code] = $handler;

        if (is_null($handler)) {
            unset($this->errorHandlers[$code]);
        }

        return $this;
    }

    public function getErrorKey(): string
    {
        return 'message';
    }

    protected function arrayGet(array $array, string $key)
    {
        $exploded = explode('.', $key, 2);

        if (! isset($exploded[1])) {
            return $array[$key] ?? null;
        }

        return $this->arrayGet($array[$exploded[0]], $exploded[1]);
    }

    protected function handleFailedRequest(Response $response, string $method, string $url, array $data = [])
    {
        $httpStatusCode = $response->status();

        $responseObj = $response->object();

        $exception = new ApiException(
            $response,
            sprintf(
                'The request ended on a %s code : %s - %s',
                $httpStatusCode,
                $responseObj->type ?? 'Unknown error type',
                $responseObj->detail ?? 'Unknown error message',
            ),
            $httpStatusCode
        );

        if ($handler = $this->errorHandlers[$httpStatusCode] ?? false) {
            return $handler->handle($exception, compact('url', 'data', 'method'));
        }

        throw $exception;
    }

    /*

    private function handleSignersExceptions(array $data, $response)
    {
        if ($response->type == 'parameters_not_valid') {
            $message = $this->handleErrorMessages($response->invalid_params);

            throw new SignerException($message);
        }
    }

    private function getRetryWaitTime(Response $response): int
    {
        $hourLimit = $response->getHeader('x-ratelimit-limit-hour');

        $minuteLimit = $response->getHeader('x-ratelimit-limit-minute');

        $hourRemain = $response->getHeader('x-ratelimit-remaining-hour');

        // $minuteRemain = $response->getHeader('x-ratelimit-remaining-minute');

        if ($hourRemain === 0) {
            return round($hourLimit / $minuteLimit) * 60000;
        }

        return 60000;
    }

    private function ratelimitRetry(Exception $exception, PendingRequest $request): bool
    {
        if (! $exception instanceof RequestException || $exception->response->status() !== 429) {
            return false;
        }

        $this->wait = $this->getRetryWaitTime($exception->response);

        $request->retry(1, $this->wait);

        return true;
    }

    if (Str::endsWith($url, '/signers')) {
                return $this->handleSignersExceptions($data, $response->object());
            }

     */
}
