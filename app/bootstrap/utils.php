<?php

declare(strict_types=1);

use Romchik38\Container\Container;

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

    // CSRF TOKEN GENERATOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorUseRandomBytes',
        '\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface',
        true,
        [32]
    );

    return $container;
};