<?php

declare(strict_types=1);

return function ($container) {

    // Root
    $container->add(
        \Romchik38\Site2\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site2\Controllers\Root\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Controllers\Root\DynamicAction::class,
        new \Romchik38\Site2\Controllers\Root\DynamicAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // ServerError
    $container->add(
        \Romchik38\Site2\Controllers\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Controllers\ServerError\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // Sitemap
    $container->add(
        \Romchik38\Site2\Controllers\Sitemap\DefaultAction::class,
        new \Romchik38\Site2\Controllers\Sitemap\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Api\Views\SitemapLinkTreeInterface::class),
            $container->get(\Romchik38\Site2\Api\Models\DTO\Views\SitemapDTOFactoryInterface::class),
            $container->get(\Romchik38\Site2\Api\Models\Virtual\Link\Sql\LinkRepositoryInterface::class)
        )
    );

    // 404
    $container->add(
        \Romchik38\Site2\Controllers\PageNotFound\DefaultAction::class,
        new \Romchik38\Site2\Controllers\PageNotFound\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // Server Error Example
    $container->add(
        \Romchik38\Site2\Controllers\ServerErrorExample\DefaultAction::class,
        new \Romchik38\Site2\Controllers\ServerErrorExample\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
        )
    );


    return $container;
};
