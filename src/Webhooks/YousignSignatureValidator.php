<?php

namespace NoviasNet\Yousign\Webhooks;

use Exception;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;

class YousignSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if (!config('yousign.webhooks.verify_signature')) {
            return true;
        }

        $signature = $request->header($config->signatureHeaderName);

        $secret = $config->signingSecret;

        // dd($signature, $secret);

        // try {
        //     hash_equals($expectedSignature, $computedSignature);
        // } catch (Exception) {
        //     return false;
        // }

        $computedSignature = 'sha256='.hash_hmac('sha256', $request->getContent(), $secret);

        return hash_equals($signature, $computedSignature);
    }
}
