<?php

declare(strict_types=1);

return function ($container) {
    
    $container->add(
        \Romchik38\Site2\Domain\Article\Services\ArticleListService::class,
        new \Romchik38\Site2\Domain\Article\Services\ArticleListService(
            $container->get(\Romchik38\Site2\Domain\Api\Article\ArticleRepositoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface::class)
        )
    );

    return $container;
};