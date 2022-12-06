<?php

namespace Assiclick\Yousign\Factories;

use Assiclick\Yousign\Yousign;
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
