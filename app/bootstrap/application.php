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
            new Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory(
                $container->get(\Romchik38\Site2\Application\ArticleListView\View\DateFormatterInterface::class),
                $container->get(\Romchik38\Site2\Application\ArticleListView\View\ReadLengthFormatterInterface::class)
            )
        )
    );

    return $container;
};