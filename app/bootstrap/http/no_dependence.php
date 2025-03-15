<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    // REQUEST
    $container->add(
        '\Psr\Http\Message\ServerRequestInterface::class',
        Laminas\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        )
    );

    $container->multi(
        '\Romchik38\Site2\Infrastructure\Services\Session\Site2Session',
        '\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface',
        true,
        []
    );

    return $container;
};