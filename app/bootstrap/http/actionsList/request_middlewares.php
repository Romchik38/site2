<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container): void {
    // Admin Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware::class,
        function($container) {
            return new \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware(
                $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
                $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
                $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
            );
        }
    );

    // Admin Users
    $container->add(
        Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminRolesMiddleware::class,
        function($container) {
            return new \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminRolesMiddleware(
                ['ADMIN_ROOT'],
                $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
                $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
                $container->get(\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService::class),
                $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
            );
        }
    );

    // Csrf
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\CsrfMiddleware::class,
        function($container) {
            return new \Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\CsrfMiddleware(
            $container->get(\Psr\Http\Message\ServerRequestInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
            );
        }
    );
};