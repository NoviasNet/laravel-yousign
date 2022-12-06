<?php

namespace Assiclick\Yousign\Facades;

use Illuminate\Support\Facades\Facade;

class Yousign extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Assiclick\Yousign\Yousign::class;
    }
}
