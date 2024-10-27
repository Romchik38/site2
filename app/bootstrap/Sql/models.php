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
        \Romchik38\Site2\Models\Link\Sql\LinkRepository::class,
        new \Romchik38\Site2\Models\Link\Sql\LinkRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            $container->get(\Romchik38\Site2\Api\Models\Virtual\Link\LinkFactoryInterface::class),
            ['array_to_json(links.path) as path', 'links_translates.*'],
            ['links', 'links_translates']
        )
    );
    $container->add(
        \Romchik38\Site2\Api\Models\Virtual\Link\Sql\LinkRepositoryInterface::class,
        $container->get(\Romchik38\Site2\Models\Link\Sql\LinkRepository::class)
    );

    $container->add(
        \Romchik38\Site2\Models\Virtual\Article\Sql\ArticleRepository::class,
        new \Romchik38\Site2\Models\Virtual\Article\Sql\ArticleRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            $container->get(\Romchik38\Site2\Api\Models\Virtual\Article\ArticleFactoryInterface::class),
            ['article.*', 'article_translates.language', 'article_translates.name', 'article_translates.description', 'article_translates.created_at', 'article_translates.updated_at', 'article_category.category_id'],
            ['article', 'article_translates', 'article_category'],
            ['article.identifier', 'article_translates.article_id', 'article_category.article_id']
        )
    );

    return $container;
};