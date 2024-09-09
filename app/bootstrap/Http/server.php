<?php

declare(strict_types=1);

return function ($container) {
    $container->add(
        \Romchik38\Server\Servers\Http\DefaultServer::class,
        new \Romchik38\Server\Servers\Http\DefaultServer(
            $container->get(\Romchik38\Server\Api\Routers\RouterInterface::class),
            new \Romchik38\Server\Controllers\Controller(
                'server-error',
                false,
                $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
                $container->get(\Romchik38\Site2\Controllers\ServerError\DefaultAction::class)
            )
        )
    );

    $container->add(
        \Romchik38\Server\Api\Servers\Http\HttpServerInterface::class,
        $container->get(\Romchik38\Server\Servers\Http\DefaultServer::class)
    );

    return $container;
};
