<?php

namespace Assiclick\Yousign\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Assiclick\Yousign\Yousign
 */
class Yousign extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Assiclick\Yousign\Yousign::class;
    }
}
