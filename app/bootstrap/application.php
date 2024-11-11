<?php

declare(strict_types=1);

return function ($container) {

    // Article
    $container->add(
        \Romchik38\Site2\Application\ArticleList\ArticleListService::class,
        new \Romchik38\Site2\Application\ArticleList\ArticleListService(
            $container->get(\Romchik38\Site2\Domain\Article\ArticleRepositoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface::class),
            $container->get(\Romchik38\Site2\Domain\Article\ArticleFilterFactoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Application\ArticleListView\ArticleListViewService::class,
        new \Romchik38\Site2\Application\ArticleListView\ArticleListViewService(
            $container->get(\Romchik38\Site2\Domain\Article\ArticleRepositoryInterface::class),
            new \Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory(
                new \Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat,
                new \Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter(
                    $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
                )
            ),
            $container->get(\Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface::class),
            new \Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\SearchCriteriaFactory
        )
    );

    // Link
    $container->add(
        \Romchik38\Site2\Application\LinkCollection\LinkCollectionService::class,
        new \Romchik38\Site2\Application\LinkCollection\LinkCollectionService(
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOFactoryInterface::class),
            $container->get(\Romchik38\Site2\Domain\Link\LinkRepositoryInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface::class,
        $container->get(\Romchik38\Site2\Application\LinkCollection\LinkCollectionService::class)
    );

    return $container;
};
