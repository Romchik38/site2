<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // TWIG LOADER
    $container->shared('\Twig\Loader\FilesystemLoader', [new Promise('view.twig.path')]);
    $container->shared('\Twig\Environment', 
        [
            new Promise('\Twig\Loader\FilesystemLoader'),
            // ['cache' => __DIR__ . '/../../.twig_cache',]
        ]
    );

    // METADATA FRONTEND
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2Metadata',
        'frontend-metadata',
        true,
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('img-folder-frontend'),
        ]
    );

    // METADATA BACKEND
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2Metadata',
        'backend-metadata',
        true,
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('img-folder-frontend'),
        ]
    );    


    // Frontend View
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigControllerViewLayout',
        'frontend-view',
        true,
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb'),
            new Promise('frontend-metadata'),
            'frontend_layout/controllers',
        ]
    );

    // Frontend 404
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\TwigSingleView',
        'frontend-view-404-page',
        true,
        [
            new Promise('\Twig\Environment'),
            'not-found/index.twig',
            new Promise('frontend-metadata'),
        ]
    );

    // ADMIN VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigControllerViewLayout',
        'backend-view',
        true,
        [
            new Promise('\Twig\Environment'),
            new Promise('\Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb'),
            new Promise('backend-metadata'),
            'admin_layout',
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
