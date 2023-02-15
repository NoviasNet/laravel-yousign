<?php

namespace Assiclick\Yousign\Webhooks;

use Assiclick\Yousign\Exceptions\WebhookFailed;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessYousignWebhookJob extends ProcessWebhookJob
{
    public function handle()
    {
        if (! isset($this->webhookCall->payload['event_name']) || $this->webhookCall->payload['event_name'] === '') {
            throw WebhookFailed::missingEvent($this->webhookCall);
        }

        event("yousign-webhooks::{$this->webhookCall->payload['event_name']}", $this->webhookCall);

        $jobClass = $this->determineJobClass($this->webhookCall->payload['event_name']);

        if ($jobClass === '') {
            return;
        }

        if (! class_exists($jobClass)) {
            throw WebhookFailed::jobClassDoesNotExist($jobClass, $this->webhookCall);
        }

        dispatch(new $jobClass($this->webhookCall));
    }

    protected function determineJobClass(string $eventType): string
    {
        $jobConfigKey = str_replace('.', '_', $eventType);

        $defaultJob = config('yousign.webhooks.default_job', '');

        return config("yousign.webhooks.jobs.{$jobConfigKey}", $defaultJob);
    }
}
