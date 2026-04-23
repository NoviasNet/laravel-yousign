<?php

namespace NoviasNet\Yousign\Exceptions;

use Exception;

class SignerException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
