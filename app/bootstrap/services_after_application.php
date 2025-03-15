<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {

    // Breadcramb
    $container->add(
        \Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb::class,
        new \Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb(
            new Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree,
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );

    // Link Tree
    $container->add(
        \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class,
        new \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );

    return $container;
};
