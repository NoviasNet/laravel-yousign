<?php

namespace Assiclick\Yousign;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Assiclick\Yousign\Commands\YousignCommand;
use Assiclick\Yousign\Factories\YousignFactory;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class YousignServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-yousign')
            ->hasConfigFile();
        // ->hasViews()
        // ->hasMigration('create_laravel-yousign_table')
        // ->hasCommand(YousignCommand::class);

        Route::macro('yousignWebhooks', function ($url) {
            return Route::post($url, '\Assiclick\Yousign\Webhooks\YousignWebhooksController');
        });
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Yousign::class, fn () => YousignFactory::execute());
    }
}
