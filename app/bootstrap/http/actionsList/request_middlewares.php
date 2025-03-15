<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container): void {
    // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware',
        [
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        ]
    );

    // Admin Users
    $container->shared(
        'Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminRolesMiddleware',
        [
            ['ADMIN_ROOT'],
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        ]
    );

    // Csrf
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\CsrfMiddleware',
        [
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        ]
    );
};