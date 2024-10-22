<?php

declare(strict_types=1);

use Romchik38\Server\Api\Results\Http\HttpRouterResultInterface;
use Romchik38\Server\Controllers\Controller;

return function ($container) {

    $notFoundController = new Controller(
        (string) HttpRouterResultInterface::NOT_FOUND_STATUS_CODE, 
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Controllers\PageNotFound\DefaultAction::class)
    );

    // ROUTER HEADERS
    $container->add(
        \Romchik38\Server\Routers\Http\DynamicRootRouter::class,
        new \Romchik38\Server\Routers\Http\DynamicRootRouter(
            $container->get(\Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Request\Http\RequestInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class),
            $container->get(\Romchik38\Server\Api\Routers\Http\HeadersCollectionInterface::class),
            $notFoundController,
            null
        )
    );

    $container->add(
        \Romchik38\Server\Api\Routers\RouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\DynamicRootRouter::class)
    );

    return $container;
};
