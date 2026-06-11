# laravel-yousign

A Laravel wrapper for the [Yousign API v3](https://developers.yousign.com/reference/oas-specification).

## Installation

```bash
composer require noviasnet/laravel-yousign
```

Publish the config file:

```bash
php artisan vendor:publish --tag="yousign-config"
```

Add the following variables to your `.env`:

```dotenv
YOUSIGN_API_KEY=your-api-key
YOUSIGN_BASE_URL=https://api-sandbox.yousign.app/v3   # or https://api.yousign.app/v3 for production
```

## Configuration

```php
// config/yousign.php
return [
    /*
     * Yousign API key. Manage keys at https://yousign.app/auth/settings/apikeys.
     */
    'api_key' => env('YOUSIGN_API_KEY'),

    /*
     * Base URL for the Yousign API.
     * Sandbox: https://api-sandbox.yousign.app/v3
     * Production: https://api.yousign.app/v3
     */
    'base_url' => env('YOUSIGN_BASE_URL', 'https://api-sandbox.yousign.app/v3'),

    'webhooks' => [
        /*
         * Yousign signs each webhook with this secret.
         * Find it at https://yousign.app/auth/api/webhooks.
         */
        'signing_secret' => env('YOUSIGN_WEBHOOK_SECRET'),

        /*
         * Fallback job class for events that have no specific job configured below.
         * Leave empty to store the webhook without processing it.
         */
        'default_job' => '',

        /*
         * Map Yousign event names (dots replaced with underscores) to job classes.
         * See https://developers.yousign.com/docs/webhooks for the full event list.
         */
        'jobs' => [
            // 'signature_request_activated' => \App\Jobs\YousignWebhooks\HandleSignatureRequestActivated::class,
            // 'signature_request_done' => \App\Jobs\YousignWebhooks\HandleSignatureRequestDone::class,
        ],

        /*
         * Model used to store incoming webhook calls.
         * Must equal or extend Spatie\WebhookClient\Models\WebhookCall.
         */
        'model' => \Spatie\WebhookClient\Models\WebhookCall::class,

        /*
         * Profile that decides whether a webhook call should be stored and processed.
         * The default profile deduplicates by payload id.
         */
        'profile' => \NoviasNet\Yousign\Webhooks\YousignWebhookProfile::class,

        /*
         * Disable signature verification in local environments.
         */
        'verify_signature' => env('YOUSIGN_SIGNATURE_VERIFY', true),
    ],
];
```

## Usage

### Facade

```php
use NoviasNet\Yousign\Facades\Yousign;
```

All resources are accessed through the `Yousign` facade. The method name maps to the resource class name (e.g. `Yousign::signatureRequest()` resolves to `SignatureRequest`).

### Signature Requests

```php
// List all signature requests
$requests = Yousign::signatureRequest()->all();

// Create a signature request
$request = Yousign::signatureRequest()->create([
    'name' => 'My contract',
    'delivery_mode' => 'email',
]);

// Fetch a single signature request
$request = Yousign::signatureRequest($id)->fetch();

// Update a signature request
Yousign::signatureRequest($id)->update(['name' => 'Updated name']);

// Activate a signature request (sends it to signers)
Yousign::signatureRequest($id)->activate();

// Cancel a signature request
Yousign::signatureRequest($id)->cancel(['reason' => 'Cancelled by user']);

// Reactivate an expired signature request
Yousign::signatureRequest($id)->reactive(['expiration_date' => '2025-12-31T00:00:00Z']);

// Delete a signature request
Yousign::signatureRequest($id)->delete();
```

### Documents

```php
// List documents on a signature request
$documents = Yousign::signatureRequest($id)->getDocuments();

// Get a single document
$document = Yousign::signatureRequest($id)->getDocument($documentId);

// Add a document (multipart upload)
Yousign::signatureRequest($id)->addDocument(
    ['nature' => 'signable_document'],
    '/path/to/file.pdf'
);

// Replace a document's file (multipart upload)
Yousign::signatureRequest($id)->replaceDocument(
    $documentId,
    ['file' => 'new-file.pdf'], // optional: 'name' => 'Contract'
    '/path/to/new-file.pdf'
);

// Update document metadata
Yousign::signatureRequest($id)->updateDocument($documentId, ['nature' => 'attachment']);

// Delete a document
Yousign::signatureRequest($id)->deleteDocument($documentId);

// Download all documents as a ZIP (returns a full Response)
$response = Yousign::signatureRequest($id)->downloadDocuments();
file_put_contents('documents.zip', $response->body());
```

### Signers

```php
// Create a signer
$signer = Yousign::signatureRequest($id)->createSigner([
    'info' => [
        'first_name' => 'Jane',
        'last_name'  => 'Doe',
        'email'      => 'jane.doe@example.com',
        'phone_number' => '+33700000000',
        'locale'     => 'fr',
    ],
    'signature_level' => 'electronic_signature',
    'signature_authentication_mode' => 'no_otp',
]);

// List signers
$signers = Yousign::signatureRequest($id)->getSigners();

// Get a signer
$signer = Yousign::signatureRequest($id)->getSigner($signerId);

// Update a signer
Yousign::signatureRequest($id)->updateSigner($signerId);

// Delete a signer
Yousign::signatureRequest($id)->deleteSigner($signerId);
```

### Audit Trails

```php
// Download all audit trails as a PDF (returns a full Response)
$response = Yousign::signatureRequest($id)->downloadAudit();
file_put_contents('audit.pdf', $response->body());

// Get a signer's audit trail metadata
$audit = Yousign::signatureRequest($id)->getSignerAudit($signerId);

// Download a signer's audit trail PDF
$pdf = Yousign::signatureRequest($id)->downloadSignerAudit($signerId);
```

## Webhooks

### Register the route

In `routes/web.php` (or `routes/api.php`):

```php
Route::yousignWebhooks('/webhooks/yousign');
```

### Configure a webhook in Yousign

Point the webhook URL to your endpoint in the [Yousign dashboard](https://yousign.app/auth/api/webhooks) and copy the signing secret into `YOUSIGN_WEBHOOK_SECRET`.

### Handle events with jobs

Create a job for each event you want to handle:

```bash
php artisan make:job YousignWebhooks/HandleSignatureRequestDone
```

```php
namespace App\Jobs\YousignWebhooks;

use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\WebhookClient\Models\WebhookCall;

class HandleSignatureRequestDone implements ShouldQueue
{
    public function __construct(public WebhookCall $webhookCall) {}

    public function handle(): void
    {
        $payload = $this->webhookCall->payload;
        // process the event...
    }
}
```

Then map the event name in `config/yousign.php`:

```php
'jobs' => [
    'signature_request_done' => \App\Jobs\YousignWebhooks\HandleSignatureRequestDone::class,
],
```

### Listen to webhook events

Every processed webhook also fires a Laravel event named `yousign-webhooks::{event_name}`. You can listen to it in `EventServiceProvider`:

```php
protected $listen = [
    'yousign-webhooks::signature_request_done' => [
        \App\Listeners\HandleSignatureRequestDone::class,
    ],
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
