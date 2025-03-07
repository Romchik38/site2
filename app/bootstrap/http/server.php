<?php

declare(strict_types=1);

use Romchik38\Server\Api\Servers\ServerInterface;

return function ($container) {
    $container->add(
        \Romchik38\Server\Servers\Http\DefaultServer::class,
        new \Romchik38\Server\Servers\Http\DefaultServer(
            $container->get(\Romchik38\Server\Api\Routers\Http\HttpRouterInterface::class),
            new \Romchik38\Server\Controllers\Controller(
                ServerInterface::SERVER_ERROR_CONTROLLER_NAME,
                false,
                $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction::class)
            ),
            $container->get(\Romchik38\Server\Api\Services\LoggerServerInterface::class)
        )
    );

    $container->add(
        \Romchik38\Server\Api\Servers\Http\HttpServerInterface::class,
        $container->get(\Romchik38\Server\Servers\Http\DefaultServer::class)
    );

    return $container;
};
