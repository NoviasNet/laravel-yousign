<?php

namespace Assiclick\Yousign\Factories;

use Assiclick\Yousign\Http\Client;
use Assiclick\Yousign\Support\Config;

class YousignClientFactory
{
    public static function execute()
    {
        return new Client(
            apiKey: Config::getApiKey(),
            baseUrl: Config::getBaseUrl(),
            brandingId: Config::getBramdingId(),
        );
    }
}
