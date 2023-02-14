<?php

namespace Assiclick\Yousigns\Webhooks;

use Exception;
use Stripe\Webhook;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class YousingWebhookSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if (! config('yousign.webhooks.verify_signature')) {
            return true;
        }

        $signature = $request->header('X-Yousign-Signature-256');
        $secret = $config->signingSecret;

        try {
            Webhook::constructEvent($request->getContent(), $signature, $secret);
        } catch (Exception) {
            return false;
        }

        return true;
    }
}
