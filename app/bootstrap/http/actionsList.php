<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;

return function (Container $container) {
    /** @var Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface $collection*/
    $collection = $container->get(Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class);

    (include_once(__DIR__ . '/actionsList/middlewares.php'))($container);
    $rootGet = (include_once(__DIR__ . '/actionsList/get.php'))($container);
    $rootPost = (include_once(__DIR__ . '/actionsList/post.php'))($container);

    /** Collection */
    $collection
        ->setController($rootGet, HttpRouterInterface::REQUEST_METHOD_GET)
        ->setController($rootPost, HttpRouterInterface::REQUEST_METHOD_POST);
    return $container;
};
