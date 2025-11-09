<?php

namespace NoviasNet\Yousign\Exceptions;

use RuntimeException;

class InvalidConfig extends RuntimeException
{
    public static function missingApiKey(): self
    {
        return new self('You need to set api_key on yousign.php config file');
    }

    // public static function missingBrandingId(): self
    // {
    //     return new self('You need to set branding_id on yousign.php config file');
    // }

    public static function wrongStringParam(string $param): self
    {
        return new self("The param {$param} on yousign.php config file must be a string");
    }
}
