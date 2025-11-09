<?php

namespace NoviasNet\Yousign\Factories;

use NoviasNet\Yousign\Yousign;
use Exception;

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
