<?php

declare(strict_types=1);

use Laminas\Diactoros\ResponseFactory;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Controllers\Controller;

return function ($container) {

    $notFoundController = new Controller(
        HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME, 
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction::class)
    );

    // ROUTER HEADERS
    $container->add(
        \Romchik38\Server\Routers\Http\DynamicRootRouter::class,
        new \Romchik38\Server\Routers\Http\DynamicRootRouter(
            new ResponseFactory,
            $container->get('\Psr\Http\Message\ServerRequestInterface'),
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface'),
            $notFoundController,
            null
        )
    );

    $container->add(
        \Romchik38\Server\Api\Routers\Http\HttpRouterInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\DynamicRootRouter::class)
    );

    return $container;
};
