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
            'signature_header_name' => 'Stripe-Signature',
            'signature_validator' => StripeSignatureValidator::class,
            'webhook_profile' => config('stripe-webhooks.profile'),
            'webhook_model' => config('stripe-webhooks.model'),
            'process_webhook_job' => ProcessStripeWebhookJob::class,
        ]);

        return (new WebhookProcessor($request, $webhookConfig))->process();
    }
}
