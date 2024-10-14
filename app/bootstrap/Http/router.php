<?php

declare(strict_types=1);

return function ($container) {

    // ROUTER HEADERS
    $container->add(
        \Romchik38\Server\Routers\Http\DynamicRootRouter::class,
        new \Romchik38\Server\Routers\Http\DynamicRootRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class),
            $container->get(\Romchik38\Server\Api\Routers\Http\HeadersCollectionInterface::class),
            null,
            null
        )
    );

    $container->add(
        \Romchik38\Server\Api\Routers\RouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\DynamicRootRouter::class)
    );

    return $container;
};
