# A simple laravel wrapper for Yousign API v3
This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-yousign.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-yousign)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require noviasnet/laravel-yousign
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-yousign-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="yousign-config"
```

This is the contents of the published config file:

```php
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

    /*
     * ID of the Branding to be used, found in your [Branding Dashboard](https://yousign.app/auth/settings/brandings)
     */
    'branding_id' => env('YOUSIGN_BRANDING_ID'),
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-yousign-views"
```

## Usage

```php
$yousign = new NoviasNet\Yousign();
echo $yousign->echoPhrase('Hello, NoviasNet!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Gabriele Pistoia](https://github.com/NoviasNet)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
