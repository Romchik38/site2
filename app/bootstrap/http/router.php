<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;

return function (Container $container) {

    // CONTROLLERS COLLECTION
    $container->multi(
        '\Romchik38\Server\Routers\Http\ControllersCollection',
        '\Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface',
        true,
        []
    );

    // ROUTER NOT FOUND CONTROLLER
    $container->multi(
        '\Romchik38\Server\Controllers\Controller',
        HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME,
        true,
        [
            HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME,
            true,
            new Promise('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction')
        ]
    );

    // ROUTER RESPONSE FACTORY
    $container->shared('\Laminas\Diactoros\ResponseFactory');

    // ROUTER
    $container->multi(
        '\Romchik38\Server\Routers\Http\DynamicRootRouter',
        '\Romchik38\Server\Api\Routers\Http\HttpRouterInterface',
        true,
        [
            new Promise('\Laminas\Diactoros\ResponseFactory'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface'),
            new Promise(HttpRouterInterface::NOT_FOUND_CONTROLLER_NAME),
            null
        ]
    );

    return $container;
};
