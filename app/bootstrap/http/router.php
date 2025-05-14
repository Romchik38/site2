<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Http\Routers\HttpRouterInterface;

return function (Container $container) {

    // CONTROLLERS COLLECTION
    $container->multi(
        '\Romchik38\Server\Http\Controller\ControllersCollection',
        '\Romchik38\Server\Http\Controller\ControllersCollectionInterface',
        true,
        []
    );

    // ROUTER NOT FOUND CONTROLLER
    $container->multi(
        '\Romchik38\Server\Http\Controller\Controller',
        HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME,
        true,
        [
            HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME,
            true,
            new Promise('\Romchik38\Site2\Infrastructure\Http\Actions\GET\PageNotFound\DefaultAction')
        ]
    );

    // ROUTER RESPONSE FACTORY
    $container->shared('\Laminas\Diactoros\ResponseFactory');

    // ROUTER
    $container->multi(
        '\Romchik38\Server\Http\Routers\DynamicRootRouter',
        '\Romchik38\Server\Http\Routers\HttpRouterInterface',
        true,
        [
            new Promise('\Laminas\Diactoros\ResponseFactory'),
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Http\Controller\ControllersCollectionInterface'),
            new Promise(HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME),
            null
        ]
    );

    return $container;
};
