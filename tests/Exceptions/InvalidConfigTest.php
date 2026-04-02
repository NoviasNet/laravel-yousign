<?php

use NoviasNet\Yousign\Exceptions\InvalidConfig;

it('missingApiKey has the correct message', function () {
    $exception = InvalidConfig::missingApiKey();

    expect($exception->getMessage())->toBe('You need to set api_key on yousign.php config file');
});

it('wrongStringParam message includes the param name', function () {
    $exception = InvalidConfig::wrongStringParam('api_key');

    expect($exception->getMessage())->toContain('api_key');
});
