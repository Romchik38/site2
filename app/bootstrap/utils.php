<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // LOGGER
    $container->multi(
        '\Romchik38\Server\Utils\Logger\DeferredLogger\FileLogger',
        '\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface',
        true,
        [
            __DIR__ . '/../var/file.log',
            7,
        ]
    );

    $container->link(
        '\Psr\Log\LoggerInterface',
        '\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'
    );

    // ADMIN ACCESS LOGGER
    $container->multi(
        '\Romchik38\Server\Utils\Logger\FileLogger',
        'access_logger',
        true,
        [
            new Promise('access.file.path'),
            4,
        ]
    );    

    // CSRF TOKEN GENERATOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorUseRandomBytes',
        '\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface',
        true,
        [32]
    );

    return $container;
};