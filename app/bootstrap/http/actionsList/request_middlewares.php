<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Http\Controller\Path;

return function (Container $container): void {
    // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminLoginMiddleware',
        [
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );

    // Admin Users
    $container->shared(
        'Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\AdminRolesMiddleware',
        [
            ['ADMIN_ROOT'],
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminUser\AdminUserService\AdminUserService'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Csrf
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\CsrfMiddleware',
        [
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Path(['root', 'login']),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );

    // Csrf admin
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\RequestMiddlewares\Admin\CsrfMiddleware',
        'request-middleware.csrf.admin',
        true,
        [
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Path(['root', 'admin']),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
};