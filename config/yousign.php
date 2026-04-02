<?php

// config for NoviasNet/Yousign
return [
    /*
     * Yousign API uses API keys to authenticate calls. You can manage those in your [Developer Dashboard](https://yousign.app/auth/settings/apikeys).
     */
    'api_key' => env('YOUSIGN_API_KEY'),

    /*
     * Yousign Enviroment (Sandbox or Production)
     *
     * https://api-sandbox.yousign.app/v3 (Sandbox)
     * https://api.yousign.app/v3 (Production)
     */
    'base_url' => env('YOUSIGN_BASE_URL', 'https://api-sandbox.yousign.app/v3'),

    'webhooks' => [
        /*
         * Yousign will sign each webhook using a secret. You can find the used secret at the
         * webhook configuration settings: https://yousign.app/auth/api/webhooks.
         */
        'signing_secret' => env('YOUSIGN_WEBHOOK_SECRET'),

        /*
         * You can define a default job that should be run for all other Yousign event name
         * without a job defined in next configuration.
         * You may leave it empty to store the job in database but without processing it.
         */
        'default_job' => '',

        /*
         * You can define the job that should be run when a certain webhook hits your application
         * here. The key is the name of the Yousign event with the `.` replaced by a `_`.
         *
         * You can find a list of Yousign webhook events here:
         * https://developers.yousign.com/docs/webhooks.
         */
        'jobs' => [
            // 'signature_request_activated' => \App\Jobs\YousignWebhooks\HandleSignatureRequestActivated::class,
            // 'signature_request_done' => \App\Jobs\YousignWebhooks\HandleSignatureRequestDone::class,
        ],

        /*
         * The classname of the model to be used. The class should equal or extend
         * Spatie\WebhookClient\Models\WebhookCall.
         */
        'model' => \Spatie\WebhookClient\Models\WebhookCall::class,

        /*
         * This class determines if the webhook call should be stored and processed.
         */
        'profile' => \NoviasNet\Yousign\Webhooks\YousignWebhookProfile::class,

        /*
         * When disabled, the package will not verify if the signature is valid.
         * This can be handy in local environments.
         */
        'verify_signature' => env('YOUSIGN_SIGNATURE_VERIFY', true),
    ],
];
