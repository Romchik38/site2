<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Api\Services\Mappers\SitemapInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container) {

    /** @var Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface $collection*/
    $collection = $container->get(Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class);
    
    /** GET */
    $root = new Controller(
        SitemapInterface::ROOT_NAME,
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Controllers\Root\DefaultAction::class),
        $container->get(\Romchik38\Site2\Controllers\Root\DynamicAction::class),
    );

    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Controllers\Sitemap\DefaultAction::class)
    );

    $serverErrorExample = new Controller(
        'server-error-example',
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Controllers\ServerErrorExample\DefaultAction::class)
    );

    $root->setChild($sitemap)->setChild($serverErrorExample);

    /** collection */
    $collection->setController($root, HttpRouterInterface::REQUEST_METHOD_GET);

    return $container;
};
