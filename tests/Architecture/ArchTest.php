<?php

arch('resources extend BaseResource')
    ->expect('NoviasNet\Yousign\Resources')
    ->classes()
    ->toExtend('NoviasNet\Yousign\Resources\BaseResource')
    ->ignoring('NoviasNet\Yousign\Resources\BaseResource');

arch('package does not depend on App namespace')
    ->expect('NoviasNet\Yousign')
    ->not->toUse('App');
