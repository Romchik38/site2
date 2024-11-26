<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    //REPOSITORIES
    $container->add(
        \Romchik38\Server\Models\TranslateEntity\Sql\TranslateEntityModelRepository::class,
        new \Romchik38\Server\Models\TranslateEntity\Sql\TranslateEntityModelRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            $container->get(\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface::class),
            'translate_entities',
            'entity_id'
        )
    );
    $container->add(
        \Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelRepositoryInterface::class,
        $container->get(\Romchik38\Server\Models\TranslateEntity\Sql\TranslateEntityModelRepository::class)
    );

    $container->add(
        \Romchik38\Site2\Infrastructure\Persist\Sql\Article\ArticleRepository::class,
        new \Romchik38\Site2\Infrastructure\Persist\Sql\Article\ArticleRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Domain\Article\ArticleRepositoryInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Persist\Sql\Article\ArticleRepository::class)
    );

    return $container;
};
