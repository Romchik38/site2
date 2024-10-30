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

    // Factories
    $container->add(
        \Romchik38\Site2\Models\Virtual\Article\Sql\ArticleSearchCriteriaFactory::class,
        new \Romchik38\Site2\Models\Virtual\Article\Sql\ArticleSearchCriteriaFactory
    );
    $container->add(
        \Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaFactoryInterface::class,
        $container->get(\Romchik38\Site2\Models\Virtual\Article\Sql\ArticleSearchCriteriaFactory::class)
    );


    return $container;
};
