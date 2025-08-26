<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Http\Routers\Middlewares\ControllerRouterMiddleware;
use Romchik38\Server\Http\Routers\Middlewares\DynamicPathRouterMiddleware;
use Romchik38\Server\Http\Routers\Middlewares\HandlerRouterMiddleware;

return function (Container $container) {

    // NOT FOUND HANDLER
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\RequestHandlers\NotFoundHandler',
        [
            new Promise('frontend-view-404-page')
        ]
    );

    // CONTROLLERS COLLECTION
    $container->multi(
        '\Romchik38\Server\Http\Controller\ControllersCollection',
        '\Romchik38\Server\Http\Controller\ControllersCollectionInterface',
        true,
        []
    );

    // ROUTER RESPONSE FACTORY
    $container->shared('\Laminas\Diactoros\ResponseFactory');

    // MIDDLEWARES
    $dynamicPathMiddleware = new DynamicPathRouterMiddleware(
        $container->get('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
        $container->get('\Laminas\Diactoros\ResponseFactory')
    );
    $containerMiddleware = new ControllerRouterMiddleware(
        $container->get('\Romchik38\Server\Http\Controller\ControllersCollectionInterface'),
        $container->get('\Laminas\Diactoros\ResponseFactory'),
        'dynamic_path_router_middleware'
    );
    $nonfoundMiddleware = new HandlerRouterMiddleware(
        $container->get('\Romchik38\Site2\Infrastructure\Http\RequestHandlers\NotFoundHandler')
    );
    // chain
    $dynamicPathMiddleware->setNext($containerMiddleware);
    $containerMiddleware->setNext($nonfoundMiddleware);

    // ROUTER
    $container->multi(
        '\Romchik38\Server\Http\Routers\MiddlewareRouter',
        'router',
        true,
        [
            $dynamicPathMiddleware
        ]
    );

    return $container;
};
