<?php

namespace Assiclick\Yousign\Exceptions\Handlers;

use Assiclick\Yousign\Exceptions\ApiException;
use Assiclick\Yousign\Exceptions\ApiBadRequestException;

/**
 * Class BadRequestErrorHandler.
 */
class BadRequestErrorHandler extends AbstractErrorHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(ApiException $exception, array $requestArguments)
    {
        $message = $this->handleErrorMessages($exception->getResponse()->json('invalid_params'));

        throw new ApiBadRequestException(
            $exception->getResponse(),
            $message,
            $exception->getCode(),
            $exception->getPrevious()
        );
    }

    protected function handleErrorMessages(array $params)
    {
        return collect($params)->map(function ($param) {
            return $param['name'] . ': ' . $param['reason'];
        })->implode(', ');
    }

    // private function convertErrorName($name): ?string
    // {
    //     if ($name == 'info[email]') {
    //         return 'Signer email';
    //     }

    //     if ($name == 'info[phone_number]') {
    //         return 'Signer phone number';
    //     }

    //     return null;
    // }

    // private function convertErrorReason($reason): ?string
    // {
    //     if ($reason == 'This field is missing.') {
    //         return 'Missing mandatory field';
    //     }

    //     if ($reason == 'This value is not a valid email address.') {
    //         return 'Not valid';
    //     }

    //     if ($reason == 'This field is mandatory with this authentication mode (otp_sms).') {
    //         return 'Missing mandatory field';
    //     }

    //     if ($reason == 'This value is not a valid phone number.') {
    //         return 'Not valid';
    //     }

    //     return null;
    // }
}
