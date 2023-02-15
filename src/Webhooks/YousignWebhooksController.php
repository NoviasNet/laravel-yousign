<?php

namespace Assiclick\Yousign\Webhooks;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookProcessor;

class YousignWebhooksController
{
    public function __invoke(Request $request, ?string $configKey = null)
    {
        $webhookConfig = new WebhookConfig([
            'name' => 'yousign',
            'signing_secret' => ($configKey) ?
                config('yousign.webhooks.signing_secret_' . $configKey) :
                config('yousign.webhooks.signing_secret'),
            'signature_header_name' => 'x-yousign-signature-256',
            'signature_validator' => YousignSignatureValidator::class,
            'webhook_profile' => config('yousign.webhooks.profile'),
            'webhook_model' => config('yousign.webhooks.model'),
            'process_webhook_job' => ProcessYousignWebhookJob::class,
        ]);

        return (new WebhookProcessor($request, $webhookConfig))->process();
    }
}
