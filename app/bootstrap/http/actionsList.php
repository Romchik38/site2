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
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Root\DefaultAction::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Root\DynamicAction::class),
    );

    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Sitemap\DefaultAction::class)
    );

    $serverErrorExample = new Controller(
        'server-error-example',
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\ServerErrorExample\DefaultAction::class)
    );

    $article = new Controller(
        'article',
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Article\DefaultAction::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Article\DynamicAction::class)
    );

    $admin = new Controller(
        'admin',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Admin\DefaultAction::class)
    );

    $register = new Controller(
        'register', 
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Register\DefaultAction::class)
    );

    $login = new Controller(
        'login', 
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Login\DefaultAction::class)
    );

    $loginAdmin = new Controller(
        'admin',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Login\Admin\DefaultAction::class),
        null,
        'login_admin'
    );

    $login->setChild($loginAdmin);

    $root
        ->setChild($sitemap)
        ->setChild($serverErrorExample)
        ->setChild($article)
        ->setChild($admin)
        ->setChild($register)
        ->setChild($login);

    /** POST */
    $rootPost = new Controller(ControllerTreeInterface::ROOT_NAME);
    $authPost = new Controller('auth');
    $authAdminPost = new Controller(
        'admin',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Auth\Admin\DefaultAction::class)
    );
    $authPost->setChild($authAdminPost);
    $rootPost->setChild($authPost);

    /** Collection */
    $collection
        ->setController($root, HttpRouterInterface::REQUEST_METHOD_GET)
        ->setController($rootPost, HttpRouterInterface::REQUEST_METHOD_POST);
    return $container;
};
