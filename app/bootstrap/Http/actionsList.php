<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container) {

    /** @var ControllersCollectionInterface $collection*/
    $collection = $container->get(Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class);
    
    $root = new Controller(
        SitemapInterface::ROOT_NAME,
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Controllers\Root\DefaultAction::class),
        $container->get(\Romchik38\Site2\Controllers\Root\DynamicAction::class),
    );

    $collection->setController($root, HttpRouterInterface::REQUEST_METHOD_GET);

    return $container;
};
