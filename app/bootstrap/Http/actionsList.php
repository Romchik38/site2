<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Router\Http\HttpRouterInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container) {

    $container->add('action_list_callback', function(string $name) use ($container){

        // GET
        $root = new Controller(
            $name,
            true,
            $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
            $container->get(\Romchik38\Site2\Controllers\Root\DefaultAction::class),
            //$container->get(\Romchik38\Site2\Controllers\Root\DynamicAction::class),
        );

        return [
            HttpRouterInterface::REQUEST_METHOD_GET => $root
        ];

    });

    return $container;
};