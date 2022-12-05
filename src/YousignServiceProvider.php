<?php

namespace Assiclick\Yousign;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Assiclick\Yousign\Commands\YousignCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-yousign_table')
            ->hasCommand(YousignCommand::class);
    }
}
