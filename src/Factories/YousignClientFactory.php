<?php

namespace NoviasNet\Yousign\Factories;

use NoviasNet\Yousign\Http\Client;
use NoviasNet\Yousign\Support\Config;

class YousignClientFactory
{
    public static function execute()
    {
        return new Client(
            apiKey: Config::getApiKey(),
            baseUrl: Config::getBaseUrl(),
            brandingId: Config::getBrandingId(),
        );
    }
}
