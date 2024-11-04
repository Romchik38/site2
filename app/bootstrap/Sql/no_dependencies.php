<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {
    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->add(
        \Romchik38\Server\Models\Sql\DatabasePostgresql::class,
        new \Romchik38\Server\Models\Sql\DatabasePostgresql($configDatabase)
    );
    $container->add(
        \Romchik38\Server\Api\Models\DatabaseInterface::class,
        $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class)
    );

    // Article
    $container->add(
        \Romchik38\Site2\Persist\Sql\Article\ArticleSearchCriteriaFactory::class,
        new \Romchik38\Site2\Persist\Sql\Article\ArticleSearchCriteriaFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface::class,
        $container->get(\Romchik38\Site2\Persist\Sql\Article\ArticleSearchCriteriaFactory::class)
    );

    $container->add(
        \Romchik38\Site2\Domain\Api\Article\ArticleFilterFactoryInterface::class,
        new Romchik38\Site2\Persist\Sql\Article\Filters\ArticleFilterFactory
    );

    return $container;
};
