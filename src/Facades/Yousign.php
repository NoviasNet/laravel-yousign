<?php

namespace NoviasNet\Yousign\Facades;

use Illuminate\Support\Facades\Facade;

class Yousign extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NoviasNet\Yousign\Yousign::class;
    }
}
