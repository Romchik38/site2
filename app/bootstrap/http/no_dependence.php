<?php

declare(strict_types=1);

return function ($container) {
    //  ROUTER
    $container->add(
        \Romchik38\Server\Results\Http\HttpRouterResult::class,
        new \Romchik38\Server\Results\Http\HttpRouterResult
    );
    $container->add(
        \Romchik38\Server\Api\Results\Http\HttpRouterResultInterface::class,
        $container->get(\Romchik38\Server\Results\Http\HttpRouterResult::class)
    );

    // REQUEST  depends only on this file or on no_dependencies global
    $container->add(
        Laminas\Diactoros\ServerRequest::class,
        Laminas\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        )
    );
    $container->add(
        Psr\Http\Message\ServerRequestInterface::class,
        $container->get(Laminas\Diactoros\ServerRequest::class)
    );

    return $container;
};