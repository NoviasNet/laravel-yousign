<?php

use Illuminate\Http\Request;
use NoviasNet\Yousign\Webhooks\YousignWebhookProfile;
use Spatie\WebhookClient\Models\WebhookCall;

it('shouldProcess returns true when no duplicate webhook exists', function () {
    $request = Request::create('/', 'POST', ['id' => 'unique-id-001']);

    $profile = new YousignWebhookProfile;

    expect($profile->shouldProcess($request))->toBeTrue();
});

it('shouldProcess returns false when a duplicate webhook already exists', function () {
    WebhookCall::create([
        'name' => 'yousign',
        'url' => 'https://example.com/webhooks/yousign',
        'headers' => [],
        'payload' => ['id' => 'duplicate-id-001'],
    ]);

    $request = Request::create('/', 'POST', ['id' => 'duplicate-id-001']);

    $profile = new YousignWebhookProfile;

    expect($profile->shouldProcess($request))->toBeFalse();
});
