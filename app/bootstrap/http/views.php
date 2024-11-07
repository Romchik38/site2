<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    $twigConfig = require_once(__DIR__ . '/../../config/shared/twig.php');

    // Loader
    $loaderConfig = $twigConfig[\Twig\Loader\FilesystemLoader::class];
    $container->add(
        \Twig\Loader\FilesystemLoader::class,
        new \Twig\Loader\FilesystemLoader(
            $loaderConfig['path']
        )
    );

    // Environment
    $container->add(
        \Twig\Environment::class,
        new \Twig\Environment(
            $container->get(\Twig\Loader\FilesystemLoader::class)
            // ? cache
        )
    );

    // Twig Default View
    $container->add(
        \Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class,
        new \Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView(
            $container->get(\Twig\Environment::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb::class),
            'base.twig'
        )
    );

    // Other classes
    $container->add(
        \Romchik38\Site2\Infrastructure\Views\Html\Classes\SitemapLinkTreeToHtml::class,
        new \Romchik38\Site2\Infrastructure\Views\Html\Classes\SitemapLinkTreeToHtml(
            $container->get(\Romchik38\Server\Api\Services\Mappers\SitemapInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Sitemap\SitemapLinkTreeInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Classes\SitemapLinkTreeToHtml::class)
    );

    return $container;
};
