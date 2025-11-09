<?php

namespace NoviasNet\Yousign\Factories;

use Exception;
use NoviasNet\Yousign\Yousign;

class YousignFactory
{
    /**
     * @throws Exception
     */
    public static function execute(): Yousign
    {
        return new Yousign(YousignClientFactory::execute());
    }
}
