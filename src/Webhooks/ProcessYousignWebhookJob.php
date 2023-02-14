<?php

namespace Assiclick\Yousign\Webhooks;

use Assiclick\Yousign\Exceptions\WebhookFailed;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessStripeWebhookJob extends ProcessWebhookJob
{
    public function handle()
    {
        if (! isset($this->webhookCall->payload['type']) || $this->webhookCall->payload['type'] === '') {
            throw WebhookFailed::missingType($this->webhookCall);
        }

        event("yousign-webhooks::{$this->webhookCall->payload['type']}", $this->webhookCall);

        $jobClass = $this->determineJobClass($this->webhookCall->payload['type']);

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

        $defaultJob = config('yousing.webhooks.default_job', '');

        return config("yousing.webhooks.jobs.{$jobConfigKey}", $defaultJob);
    }
}
