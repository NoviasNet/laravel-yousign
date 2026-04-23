<?php

use Illuminate\Http\Request;
use NoviasNet\Yousign\Exceptions\WebhookFailed;
use Spatie\WebhookClient\Models\WebhookCall;

function makeWebhookCall(int $id = 1, string $eventName = 'signature_request_done'): WebhookCall
{
    $webhookCall = new WebhookCall();
    $webhookCall->id = $id;
    $webhookCall->payload = ['event_name' => $eventName];

    return $webhookCall;
}

it('jobClassDoesNotExist message contains the id, event_name, and job class', function () {
    $webhookCall = makeWebhookCall(42, 'signature_request_done');
    $jobClass = 'App\Jobs\HandleSignature';

    $exception = WebhookFailed::jobClassDoesNotExist($jobClass, $webhookCall);

    expect($exception->getMessage())
        ->toContain('42')
        ->toContain('signature_request_done')
        ->toContain($jobClass);
});

it('missingEvent message contains the id', function () {
    $webhookCall = makeWebhookCall(99, '');

    $exception = WebhookFailed::missingEvent($webhookCall);

    expect($exception->getMessage())->toContain('99');
});

it('render returns a 400 response', function () {
    $webhookCall = makeWebhookCall();
    $exception = WebhookFailed::missingEvent($webhookCall);

    $response = $exception->render(Request::create('/'));

    expect($response->getStatusCode())->toBe(400);
});
