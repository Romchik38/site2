<?php

declare(strict_types=1);

return function ($container) {
    
    // Article
    $container->add(
        \Romchik38\Site2\Domain\Article\Services\ArticleListService::class,
        new \Romchik38\Site2\Domain\Article\Services\ArticleListService(
            $container->get(\Romchik38\Site2\Domain\Api\Article\ArticleRepositoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface::class),
            $container->get(\Romchik38\Site2\Domain\Api\Article\ArticleFilterFactoryInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Domain\Article\View\ArticleDTOFactory::class,
        new \Romchik38\Site2\Domain\Article\View\ArticleDTOFactory(
            $container->get(\Romchik38\Site2\Api\Services\DateFormatterInterface::class),
            $container->get(\Romchik38\Site2\Api\Services\ReadLengthFormatterInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Domain\Article\View\ArticleViewRepository::class,
        new \Romchik38\Site2\Domain\Article\View\ArticleViewRepository(
            $container->get(\Romchik38\Site2\Domain\Api\Article\ArticleRepositoryInterface::class),
            $container->get(\Romchik38\Site2\Domain\Article\View\ArticleDTOFactory::class)
        )
    );

    return $container;
};