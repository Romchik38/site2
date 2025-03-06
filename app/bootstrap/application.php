<?php

declare(strict_types=1);

return function ($container) {

    // // ArticleListService
    // $container->add(
    //     \Romchik38\Site2\Application\ArticleList\ArticleListService::class,
    //     new \Romchik38\Site2\Application\ArticleList\ArticleListService(
    //         $container->get(\Romchik38\Site2\Domain\Article\ArticleRepositoryInterface::class),
    //         $container->get(\Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface::class),
    //         $container->get(\Romchik38\Site2\Domain\Article\ArticleFilterFactoryInterface::class)
    //     )
    // );

    // ArticleListViewService
    $container->add(
        \Romchik38\Site2\Application\ArticleListView\ArticleListViewService::class,
        new \Romchik38\Site2\Application\ArticleListView\ArticleListViewService(
            $container->get(\Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface::class),
            new \Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\SearchCriteriaFactory
        )
    );

    // Article View
    $container->add(
        \Romchik38\Site2\Application\ArticleView\ArticleViewService::class,
        new \Romchik38\Site2\Application\ArticleView\ArticleViewService(
            $container->get(\Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface::class)
        )
    );

    // Admin User Check Service 
    $container->add(
        \Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService::class,
        new \Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService(
            $container->get(\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface::class)
        )
    );

    return $container;
};
