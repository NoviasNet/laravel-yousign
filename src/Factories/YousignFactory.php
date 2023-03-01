<?php

namespace Assiclick\Yousign\Factories;

use Exception;
use Assiclick\Yousign\Yousign;

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
