<?php

declare(strict_types=1);

return function ($container) {
    //$controllersList = require_once(__DIR__ . '/controllersList.php');
    $actionList = $container->get('action_list_callback');

    // ROUTER HEADERS
    $headersFn = $container->get('headers');
    $headers = [$headersFn];

    $container->add(
        \Romchik38\Server\Routers\Http\DymanicRootRouter::class,
        new \Romchik38\Server\Routers\Http\DymanicRootRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface::class),
            [$actionList],
            $headers,
            null,
            null
        )
    );

    $container->add(
        \Romchik38\Server\Api\Router\RouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\DymanicRootRouter::class)
    );

    return $container;
};
