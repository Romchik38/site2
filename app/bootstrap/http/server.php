<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    $container->multi(
        '\Romchik38\Server\Http\Servers\DefaultServer',
        '\Romchik38\Server\Http\Servers\HttpServerInterface',
        true,
        [
            new Promise('\Romchik38\Server\Http\Routers\HttpRouterInterface'),
            new \Romchik38\Site2\Infrastructure\Http\RequestHandlers\ServerErrorHandler(),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
        ]
    );

    return $container;
};
