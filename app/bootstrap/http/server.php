<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Http\Servers\ServerInterface;

return function (Container $container) {
    $container->multi(
        '\Romchik38\Server\Http\Controller\Controller',
        ServerInterface::SERVER_ERROR_CONTROLLER_NAME,
        true,
        [
            ServerInterface::SERVER_ERROR_CONTROLLER_NAME,
            false,
            new Promise('\Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerError\DefaultAction')
        ]
    );

    $container->multi(
        '\Romchik38\Server\Http\Servers\DefaultServer',
        '\Romchik38\Server\Http\Servers\HttpServerInterface',
        true,
        [
            new Promise('\Romchik38\Server\Http\Routers\HttpRouterInterface'),
            new Promise(ServerInterface::SERVER_ERROR_CONTROLLER_NAME),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
        ]
    );

    return $container;
};
