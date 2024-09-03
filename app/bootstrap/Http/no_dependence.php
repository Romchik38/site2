<?php

declare(strict_types=1);

return function ($container) {
    //  ROUTER
    $container->add(
        \Romchik38\Server\Results\Http\HttpRouterResult::class,
        new \Romchik38\Server\Results\Http\HttpRouterResult()
    );
    $container->add(
        \Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class,
        $container->get(\Romchik38\Server\Results\Http\HttpRouterResult::class)
    );

    // SERVICES
    $container->add(
        \Romchik38\Server\Services\Request\Http\UriFactory::class,
        new \Romchik38\Server\Services\Request\Http\UriFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface::class,
        $container->get(\Romchik38\Server\Services\Request\Http\UriFactory::class)
    );

    return $container;
};