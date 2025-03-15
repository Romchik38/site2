<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Services\Urlbuilder\DynamicTarget;

return function (Container $container) {

    // Logger
    $container->multi(
        '\Romchik38\Server\Services\Logger\Loggers\FileLogger',
        '\Romchik38\Server\Api\Services\LoggerServerInterface',
        true,
        [
            __DIR__ . '/../var/file.log',
            7
        ]
    );

    //Urlbuilder
    $container->multi(
        '\Romchik38\Server\Services\Urlbuilder\Urlbuilder',
        '\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface',
        true,
        [
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\DynamicTarget')
        ]
    );

    $container->shared('\Romchik38\Server\Services\Urlbuilder\DynamicTarget', [
        new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface')
    ]);
    
    return $container;
};