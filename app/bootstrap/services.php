<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    // Logger
    $container->add(
        \Romchik38\Server\Services\Logger\Loggers\FileLogger::class,
        new \Romchik38\Server\Services\Logger\Loggers\FileLogger(
            __DIR__ . '/../var/file.log',
            7
        )
    );

    $container->add(
        \Romchik38\Server\Api\Services\LoggerServerInterface::class,
        $container->get(\Romchik38\Server\Services\Logger\Loggers\FileLogger::class)
    );

    return $container;
};