<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Services\Urlbuilder\DynamicTarget;

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

    //Urlbuilder
    $container->add(
        \Romchik38\Server\Services\Urlbuilder\Urlbuilder::class,
        new \Romchik38\Server\Services\Urlbuilder\Urlbuilder(
            $container->get(\Psr\Http\Message\ServerRequestInterface::class),
            new DynamicTarget(
                $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class)
            )
        )
    );
    $container->add(
        \Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class,
        $container->get(\Romchik38\Server\Services\Urlbuilder\Urlbuilder::class)
    );
    
    return $container;
};