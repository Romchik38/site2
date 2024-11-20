<?php

declare(strict_types=1);

use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function ($container) {

    $errorConfig = include_once(__DIR__ . '/../config/shared/errors.php');

    // Root
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Root\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Root\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Root\DynamicAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // ServerError
    $serverErrorResponseFile = $errorConfig['server-error-page']
        ?? throw new MissingRequiredParameterInFileError('Missing server-error-page config parameter');

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\ServerError\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class),
            $serverErrorResponseFile
        )
    );

    // Sitemap
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Infrastructure\Controllers\Sitemap\SitemapLinkTreeInterface::class),
            new Romchik38\Site2\Infrastructure\Controllers\Sitemap\DefaultAction\SitemapDTOFactory,
        )
    );

    // Not found
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\PageNotFound\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\PageNotFound\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // Server Error Example
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\ServerErrorExample\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\ServerErrorExample\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    // Article
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction
        (
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Application\ArticleListView\ArticleListViewService::class),
            new Romchik38\Site2\Infrastructure\Views\Html\Classes\ArticlePaginationFactory,
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
            new \Romchik38\Server\Services\Urlbuilder\Http\UrlbuilderFactory
        )
    );

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Article\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Article\DynamicAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Application\ArticleView\ArticleViewService::class),
        )
    );

    // Img
    $container->add(
        Romchik38\Site2\Infrastructure\Controllers\Img\DefaultAction::class,
        new Romchik38\Site2\Infrastructure\Controllers\Img\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class),
        )
    );

    return $container;
};
