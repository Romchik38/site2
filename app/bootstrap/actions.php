<?php

declare(strict_types=1);

return function ($container) {

    $errorConfig = include_once(__DIR__ . '/../config/shared/errors.php');

    // Root
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Root\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Root\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Root\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Root\DynamicAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // ServerError
    $serverErrorResponseFile = $errorConfig['server-error-page']
        ?? throw new RuntimeException('Missing server-error-page config parameter');

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\ServerError\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class),
            $serverErrorResponseFile
        )
    );

    // Sitemap
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Sitemap\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Sitemap\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\Sitemap\SitemapLinkTreeInterface::class),
            new Romchik38\Site2\Infrastructure\Controllers\Actions\Sitemap\DefaultAction\SitemapDTOFactory,
        )
    );

    // Not found
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\PageNotFound\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\PageNotFound\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // Server Error Example
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\ServerErrorExample\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\ServerErrorExample\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    // Article
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Article\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Article\DefaultAction
        (
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Application\ArticleListView\ArticleListViewService::class),
            $container->get(Psr\Http\Message\ServerRequestInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Article\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Article\DynamicAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Application\ArticleView\ArticleViewService::class),
        )
    );

    // Admin
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Admin\DefaultAction(
            $container->get('admin_view')
        )
    );
    
     // Admin Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Login\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Login\Admin\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class)
        )
    );

    // Register
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Register\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Register\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class)
        )
    );
    
    // Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Login\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Login\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Server\Api\Services\SessionInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class)
        )
    );

    // [POST]
    // Auth Admin
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\Auth\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\Auth\Admin\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    return $container;
};
