<?php

namespace NoviasNet\Yousign\Exceptions;

use Exception;

class SignerException extends Exception
{
    /**
     * @var string
     */
    public $message;

    /**
     * @param  @string $message
     * @return void
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
