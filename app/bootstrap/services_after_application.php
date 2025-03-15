<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    // Breadcramb
    /** @todo move to service */
    $container->shared(
        '\Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb',
        [
            new Promise('\Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree'),
            new promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface')
        ]
    );

    $container->shared('\Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree');

    /** @todo move to service */
    // Link Tree
    $container->multi(
        '\Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree',
        '\Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface',
        true,
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface')
        ]
    );

    return $container;
};
