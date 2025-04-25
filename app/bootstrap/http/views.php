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
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView',
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            'base.twig'
        ]
    );

    // Admin View
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView',
        'admin_view',
        true,
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            'base_admin.twig'
        ]
    );

    // Other classes
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Classes\SitemapLinkTreeToHtml',
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\SitemapLinkTreeInterface',
        true,
        [
            new Promise('\Romchik38\Server\Services\Mappers\ControllerTree\ControllerTree'),
            new Promise('\Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface')
        ]
    );

    return $container;
};
