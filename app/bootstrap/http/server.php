<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\RequestHandlers\ServerErrorHandler',
        [
            new Promise('server-error-page')
        ]
    );

    $container->multi(
        '\Romchik38\Server\Http\Servers\DefaultServer',
        '\Romchik38\Server\Http\Servers\HttpServerInterface',
        true,
        [
            new Promise('router'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\RequestHandlers\ServerErrorHandler'),
            new Promise('\Psr\Log\LoggerInterface')
        ]
    );

    return $container;
};
