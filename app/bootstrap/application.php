<?php

declare(strict_types=1);

use Romchik38\Container\Promise;

return function ($container) {

    /** @todo waiting to refactor */
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
    $container->shared(
        '\Romchik38\Site2\Application\ArticleListView\ArticleListViewService',
        [
            new Promise('\Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\SearchCriteriaFactory')
        ]
    );

    $container->shared('\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\SearchCriteriaFactory', []);

    // Article View
    $container->shared(
        '\Romchik38\Site2\Application\ArticleView\ArticleViewService',
        [
            new Promise('\Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface')
        ]
    );

    // Admin User Check Service 
    $container->shared(
        '\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService',
        [
            new Promise('\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface')
        ]
    );

    // Admin User Roles
    $container->shared(
        '\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService',
        [
            new Promise('\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface')
        ]
    );

    // User Check
    $container->shared('\Romchik38\Site2\Application\User\UserCheck\UserCheckService', []);

    return $container;
};
