<?php

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use NoviasNet\Yousign\Exceptions\WebhookFailed;
use NoviasNet\Yousign\Webhooks\ProcessYousignWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

// Minimal stub job used to verify dispatch
class HandleSignatureRequestDone implements \Illuminate\Contracts\Queue\ShouldQueue
{
    use \Illuminate\Bus\Queueable;

    public function __construct(public WebhookCall $webhookCall) {}

    public function handle(): void {}
}

function makeWebhookCallRecord(array $payload): WebhookCall
{
    return WebhookCall::create([
        'name'    => 'yousign',
        'url'     => 'https://example.com/webhooks/yousign',
        'headers' => [],
        'payload' => $payload,
    ]);
}

it('throws WebhookFailed when event_name is missing from payload', function () {
    $webhookCall = makeWebhookCallRecord([]);

    $job = new ProcessYousignWebhookJob($webhookCall);

    expect(fn () => $job->handle())->toThrow(WebhookFailed::class);
});

it('throws WebhookFailed when event_name is an empty string', function () {
    $webhookCall = makeWebhookCallRecord(['event_name' => '']);

    $job = new ProcessYousignWebhookJob($webhookCall);

    expect(fn () => $job->handle())->toThrow(WebhookFailed::class);
});

it('fires a yousign-webhooks event with the event_name', function () {
    Event::fake();

    $webhookCall = makeWebhookCallRecord(['event_name' => 'signature_request_done']);
    config()->set('yousign.webhooks.jobs', []);
    config()->set('yousign.webhooks.default_job', '');

    $job = new ProcessYousignWebhookJob($webhookCall);
    $job->handle();

    Event::assertDispatched('yousign-webhooks::signature_request_done');
});

it('returns without dispatching when no job is configured for the event', function () {
    Queue::fake();
    Event::fake();

    $webhookCall = makeWebhookCallRecord(['event_name' => 'signature_request_activated']);
    config()->set('yousign.webhooks.jobs', []);
    config()->set('yousign.webhooks.default_job', '');

    $job = new ProcessYousignWebhookJob($webhookCall);
    $job->handle();

    Queue::assertNothingPushed();
});

it('throws WebhookFailed when configured job class does not exist', function () {
    $webhookCall = makeWebhookCallRecord(['event_name' => 'signature_request_done']);
    config()->set('yousign.webhooks.jobs.signature_request_done', 'App\Jobs\NonExistentJob');
    config()->set('yousign.webhooks.default_job', '');

    $job = new ProcessYousignWebhookJob($webhookCall);

    expect(fn () => $job->handle())->toThrow(WebhookFailed::class);
});

it('dispatches the configured job class when it exists', function () {
    Queue::fake();
    Event::fake();

    $webhookCall = makeWebhookCallRecord(['event_name' => 'signature_request_done']);
    config()->set('yousign.webhooks.jobs.signature_request_done', HandleSignatureRequestDone::class);
    config()->set('yousign.webhooks.default_job', '');

    $job = new ProcessYousignWebhookJob($webhookCall);
    $job->handle();

    Queue::assertPushed(HandleSignatureRequestDone::class);
});
