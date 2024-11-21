<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Routers\Http\HttpRouterInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Controllers\Controller;

/** @todo split controller entity and collection:
 *  - entity - common
 *  - collection - http
 * 
 */
return function (Container $container) {

    /** @var Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface $collection*/
    $collection = $container->get(Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class);

    /** GET */
    $root = new Controller(
        ControllerTreeInterface::ROOT_NAME,
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Root\DefaultAction::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Root\DynamicAction::class),
    );

    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction::class)
    );

    $serverErrorExample = new Controller(
        'server-error-example',
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\ServerErrorExample\DefaultAction::class)
    );

    $article = new Controller(
        'article',
        true,
        $container->get(\Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Article\DynamicAction::class)
    );

    $root
        ->setChild($sitemap)
        ->setChild($serverErrorExample)
        ->setChild($article);

    /** collection */
    $collection->setController($root, HttpRouterInterface::REQUEST_METHOD_GET);

    return $container;
};
