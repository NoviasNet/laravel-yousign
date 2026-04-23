<?php

use Illuminate\Http\Request;
use NoviasNet\Yousign\Webhooks\ProcessYousignWebhookJob;
use NoviasNet\Yousign\Webhooks\YousignSignatureValidator;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;

function makeWebhookConfig(string $secret = 'test-secret'): WebhookConfig
{
    return new WebhookConfig([
        'name' => 'yousign',
        'signing_secret' => $secret,
        'signature_header_name' => 'x-yousign-signature-256',
        'signature_validator' => YousignSignatureValidator::class,
        'webhook_profile' => ProcessEverythingWebhookProfile::class,
        'webhook_model' => WebhookCall::class,
        'process_webhook_job' => ProcessYousignWebhookJob::class,
    ]);
}

it('returns true when verify_signature is disabled', function () {
    config()->set('yousign.webhooks.verify_signature', false);

    $request = Request::create('/', 'POST', [], [], [], [], 'body');
    $validator = new YousignSignatureValidator;

    expect($validator->isValid($request, makeWebhookConfig()))->toBeTrue();
});

it('returns true for a valid HMAC signature', function () {
    config()->set('yousign.webhooks.verify_signature', true);

    $secret = 'my-secret';
    $body = '{"event_name":"signature_request_done"}';
    $signature = 'sha256='.hash_hmac('sha256', $body, $secret);

    $request = Request::create('/', 'POST', [], [], [], [], $body);
    $request->headers->set('x-yousign-signature-256', $signature);

    $validator = new YousignSignatureValidator;

    expect($validator->isValid($request, makeWebhookConfig($secret)))->toBeTrue();
});

it('returns false for an invalid signature', function () {
    config()->set('yousign.webhooks.verify_signature', true);

    $body = '{"event_name":"signature_request_done"}';
    $request = Request::create('/', 'POST', [], [], [], [], $body);
    $request->headers->set('x-yousign-signature-256', 'sha256=wrong-signature');

    $validator = new YousignSignatureValidator;

    expect($validator->isValid($request, makeWebhookConfig('my-secret')))->toBeFalse();
});
