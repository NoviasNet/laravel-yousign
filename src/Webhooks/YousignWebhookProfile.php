<?php

namespace Assiclick\Yousign\Webhooks;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class YousingWebhookProfile implements WebhookProfile
{
    public function shouldProcess(Request $request): bool
    {
        return ! WebhookCall::where('event_name', 'yousign')->where('payload->id', $request->get('id'))->exists();
    }
}
