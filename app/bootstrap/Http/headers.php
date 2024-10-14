<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Api\Routers\Http\HeadersCollectionInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Routers\Http\HeadersCollection;

/** 
 * Header Collection Http
 */
return function (Container $container): Container {

    $s = ControllerInterface::PATH_SEPARATOR;
    $a = ControllerInterface::PATH_DYNAMIC_ALL;

    // GET
    $arr = [
        /** root => header root instance */
        new Romchik38\Site2\Router\Http\RouterHeaders\Root(
            SitemapInterface::ROOT_NAME, //   root
            HttpRouterInterface::REQUEST_METHOD_GET
        ),
        new Romchik38\Site2\Router\Http\RouterHeaders\Root(
            SitemapInterface::ROOT_NAME . $s . $a, // root<>*
            HttpRouterInterface::REQUEST_METHOD_GET
        ),
    ];

    $container->add(
        \Romchik38\Server\Routers\Http\HeadersCollection::class,
        new HeadersCollection($arr)
    );

    $container->add(
        \Romchik38\Server\Api\Routers\Http\HeadersCollectionInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\HeadersCollection::class)
    );

    return $container;
};
