<?php

declare(strict_types=1);

return function ($container) {
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

    // SESSION
    $container->add(
        \Romchik38\Site2\Infrastructure\Services\Session\Site2Session::class,
        new \Romchik38\Site2\Infrastructure\Services\Session\Site2Session()
    );
    $container->add(
        Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2Session::class)
    );

    return $container;
};