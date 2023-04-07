<?php

namespace Assiclick\Yousign\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Client\Response;

class ApiException extends Exception
{
    protected $response;

    /**
     * @var string|null can be used to specify from which API the exception has been thrown
     */
    protected $source;

    public function __construct(Response $response, $message = '', $httpCode = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $httpCode, $previous);
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getResponse($key = null)
    {
        return $key ? $this->response->json($key) : $this->response;
    }

    /**
     * @return mixed
     */
    public function getApiMessage()
    {
        return $this->getResponse('message');
    }

    /**
     * @return mixed
     */
    public function getApiErrors()
    {
        return $this->getResponse('errors');
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
