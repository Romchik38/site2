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
            $container->get(\Romchik38\Site2\Domain\Link\LinkRepositoryInterface::class)
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
        new \Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            new \Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction\ViewDTOFactory,
            $container->get(\Romchik38\Site2\Application\ArticleList\ArticleListService::class),
            $container->get(\Romchik38\Site2\Infrastructure\Persist\Sql\Article\ArticleViewRepository::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Article\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Article\DynamicAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class),
            $container->get(\Romchik38\Site2\Domain\Article\ArticleRepositoryInterface::class),
        )
    );

    return $container;
};
