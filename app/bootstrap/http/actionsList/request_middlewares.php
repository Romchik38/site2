<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container): void {
    // Admin Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware::class,
        new \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware(
                $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
                $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
                $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        )
    );

    // Admin Users
    $container->add(
        Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminRolesMiddleware::class,
        new \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminRolesMiddleware(
            ['ADMIN_ROOT'],
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            $container->get('\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        )
    );

    // Csrf
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\CsrfMiddleware::class,
        new \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\CsrfMiddleware(
        $container->get('\Psr\Http\Message\ServerRequestInterface'),
        $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
        $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        )
    );
};