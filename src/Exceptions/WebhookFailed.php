<?php

namespace NoviasNet\Yousign\Exceptions;

use Exception;
use Spatie\WebhookClient\Models\WebhookCall;

class WebhookFailed extends Exception
{
    public static function jobClassDoesNotExist(string $jobClass, WebhookCall $webhookCall): self
    {
        return new self("Could not process webhook id `{$webhookCall->id}` of event `{$webhookCall->payload['event_name']} because the configured jobclass `{$jobClass}` does not exist.");
    }

    public static function missingEvent(WebhookCall $webhookCall): self
    {
        return new self("Webhook call id `{$webhookCall->id}` did not contain a event name. Valid Yousign webhook calls should always contain a event name.");
    }

    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }
}
