<?php

namespace NoviasNet\Yousign\Support;

use NoviasNet\Yousign\Exceptions\InvalidConfig;

class Config
{
    /**
     * @throws Throwable
     */
    public static function getApiKey(): string
    {
        $apiKey = config('yousign.api_key');

        throw_if(empty($apiKey), InvalidConfig::missingApiKey());

        throw_if(!is_string($apiKey), InvalidConfig::wrongStringParam('api_key'));

        return $apiKey;
    }

    /**
     * @throws Throwable
     */
    public static function getBrandingId(): string
    {
        $brandingId = config('yousign.branding_id');

        // throw_if(empty($brandingId), InvalidConfig::missingBrandingId());

        throw_if(!is_string($brandingId), InvalidConfig::wrongStringParam('branding_id'));

        return $brandingId;
    }

    public static function getBaseUrl(): string
    {
        $baseUrl = config('yousign.base_url');

        throw_if(!is_string($baseUrl), InvalidConfig::wrongStringParam('endpoint'));

        return $baseUrl;
    }
}
