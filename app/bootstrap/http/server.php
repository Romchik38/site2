<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Api\Servers\ServerInterface;

return function (Container $container) {
    $container->multi(
        '\Romchik38\Server\Controllers\Controller',
        ServerInterface::SERVER_ERROR_CONTROLLER_NAME,
        true,
        [
            ServerInterface::SERVER_ERROR_CONTROLLER_NAME,
            false,
            new Promise('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction')
        ]
    );

    $container->multi(
        '\Romchik38\Server\Servers\Http\DefaultServer',
        '\Romchik38\Server\Api\Servers\Http\HttpServerInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Routers\Http\HttpRouterInterface'),
            new Promise(ServerInterface::SERVER_ERROR_CONTROLLER_NAME),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    return $container;
};
