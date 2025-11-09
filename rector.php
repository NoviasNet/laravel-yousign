<?php

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelLevelSetList;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\CodeQuality\Rector\ClassMethod\ExplicitReturnNullRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\TypeDeclaration\Rector\BooleanAnd\BinaryOpNullableToInstanceofRector;
use Rector\CodingStyle\Rector\FunctionLike\FunctionLikeToFirstClassCallableRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;

return RectorConfig::configure()
    ->withPaths([
        // __DIR__ . '/app/Engines',
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/lang',
        // __DIR__ . '/nova-components',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        // __DIR__ . '/tests',
    ])
    ->withPhpSets(php83: true)
    ->withSkip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
        BinaryOpNullableToInstanceofRector::class,
        DeclareStrictTypesRector::class,
        EloquentMagicMethodToQueryBuilderRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        ExplicitReturnNullRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        FunctionLikeToFirstClassCallableRector::class,
        NullableCompareToNullRector::class,
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
        SeparateMultiUseImportsRector::class,
        StringClassNameToClassConstantRector::class,
    ])
    ->withPreparedSets(
        carbon: true,
        codeQuality: true,
        codingStyle: true,
        deadCode: true,
        earlyReturn: true,
        instanceOf: true,
        naming: true,
        privatization: true,
        rectorPreset: true,
        strictBooleans: false,
        typeDeclarations: true,
    )
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_110,
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
    ])
    ->withImportNames();
// ->withCodeQualityLevel(74);
// ->withCodingStyleLevel(25);
// ->withTypeCoverageLevel(53);
// ->withDeadCodeLevel(51);
