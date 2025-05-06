<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Server\Http\Routers\HttpRouterInterface;

return function (Container $container) {
    /** @var Romchik38\Server\Http\Controller\ControllersCollectionInterface $collection*/
    $collection = $container->get('\Romchik38\Server\Http\Controller\ControllersCollectionInterface');

    (include_once(__DIR__ . '/actionsList/request_middlewares.php'))($container);
    $rootGet = (include_once(__DIR__ . '/actionsList/get.php'))($container);
    $rootPost = (include_once(__DIR__ . '/actionsList/post.php'))($container);

    /** Collection */
    $collection
        ->setController($rootGet, HttpRouterInterface::REQUEST_METHOD_GET)
        ->setController($rootPost, HttpRouterInterface::REQUEST_METHOD_POST);
    return $container;
};
