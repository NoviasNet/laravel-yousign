<?php

use NoviasNet\Yousign\Exceptions\InvalidConfig;
use NoviasNet\Yousign\Support\Config;

it('getApiKey throws when api_key is empty', function () {
    config()->set('yousign.api_key', '');

    expect(fn () => Config::getApiKey())->toThrow(InvalidConfig::class, 'api_key');
});

it('getApiKey throws when api_key is null', function () {
    config()->set('yousign.api_key', null);

    expect(fn () => Config::getApiKey())->toThrow(InvalidConfig::class);
});

it('getApiKey returns the key when set', function () {
    config()->set('yousign.api_key', 'test-api-key');

    expect(Config::getApiKey())->toBe('test-api-key');
});

it('getBaseUrl throws when base_url is null', function () {
    config()->set('yousign.base_url', null);

    expect(fn () => Config::getBaseUrl())->toThrow(InvalidConfig::class, 'endpoint');
});

it('getBaseUrl returns the url when set', function () {
    config()->set('yousign.base_url', 'https://api-sandbox.yousign.app/v3');

    expect(Config::getBaseUrl())->toBe('https://api-sandbox.yousign.app/v3');
});
