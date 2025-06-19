<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // TWIG LOADER
    $container->shared('\Twig\Loader\FilesystemLoader', [new Promise('view.twig.path')]);
    $container->shared('\Twig\Environment', [new Promise('\Twig\Loader\FilesystemLoader')]);

    // Frontend View
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout',
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('img-folder-frontend'),
            'frontend_layout/controllers'
        ]
    );

    // Frontend 404
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigSingleView',
        'frontend_404_page',
        true,
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            'not-found/index.twig'
        ]
    );

    // ADMIN VIEW LAYOUT
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout',
        'admin_view_layout',
        true,
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('img-folder-frontend'),
            'admin_layout'
        ]
    );

    // Other classes
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\SitemapLinkTreeToHtml',
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\SitemapLinkTreeInterface',
        true,
        [
            new Promise('\Romchik38\Server\Http\Controller\Mappers\ControllerTree\ControllerTree'),
            new Promise('\Romchik38\Server\Http\Controller\Mappers\LinkTree\LinkTreeInterface')
        ]
    );

    return $container;
};
