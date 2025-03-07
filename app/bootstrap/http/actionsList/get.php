<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container): ControllerInterface {
    /** GET */
    $root = new Controller(
        ControllerTreeInterface::ROOT_NAME,
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction::class),
    );
    $sitemap = new Controller(
        'sitemap',
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction::class)
    );
    $serverErrorExample = new Controller(
        'server-error-example',
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction::class)
    );
    $article = new Controller(
        'article',
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction::class),
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction::class)
    );
    $admin = new Controller(
        'admin',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction::class)
    );
    $register = new Controller(
        'register', 
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction::class)
    );
    $login = new Controller(
        'login', 
        true,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction::class)
    );
    $loginAdmin = new Controller(
        'admin',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction::class),
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
    return $root;
};