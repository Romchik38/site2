<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Controllers\Path;
use Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface;

return function (Container $container): void {
    // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminLoginMiddleware',
        [
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface')
        ]
    );

    // Admin Users
    $container->shared(
        'Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminRolesMiddleware',
        [
            ['ADMIN_ROOT'],
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface')
        ]
    );

    // Csrf
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\CsrfMiddleware',
        [
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Path(['root', 'login']),
            Site2SessionInterface::CSRF_TOKEN_FIELD
        ]
    );

    // Csrf admin
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\CsrfMiddleware',
        'request-middleware.csrf.admin',
        true,
        [
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Path(['root', 'admin']),
            Site2SessionInterface::ADMIN_CSRF_TOKEN_FIELD
        ]
    );
};