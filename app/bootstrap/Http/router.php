<?php

declare(strict_types=1);

return function ($container) {
    //$controllersList = require_once(__DIR__ . '/controllersList.php');
    $actionList = $container->get('action_list_callback');

    // ROUTER HEADERS
    $headersFn = $container->get('headers');
    $headers = [$headersFn];

    $container->add(
        \Romchik38\Server\Routers\Http\DynamicRootRouter::class,
        new \Romchik38\Server\Routers\Http\DynamicRootRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            [$actionList],
            $headers,
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
