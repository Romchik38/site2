<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->multi(
        '\Romchik38\Server\Models\Sql\DatabasePostgresql',
        '\Romchik38\Server\Api\Models\DatabaseInterface',
        true,
        [$configDatabase]
    );
    
    // TRANSLATE ENTITY MODEL REPOSITORY
    $container->multi(
        '\Romchik38\Server\Models\TranslateEntity\Sql\TranslateEntityModelRepository',
        '\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface'),
            new Promise('\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface'),
            'translate_entities',
            'entity_id'
        ]
    );

    // ADMIN USER REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser\AdminUserRepository',
        '\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface')
        ]
    );

    // ARTICLE LIST VIEW REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\ArticleListViewRepository',
        '\Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface'),
            new Promise('\Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory'),
            new Promise('\Romchik38\Site2\Application\ArticleListView\View\ImageDTOFactory')
        ]
    );

    // ARTICLE VIEW REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView\ArticleViewRepository',
        '\Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface'),
            new Promise('\Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory'),
            new Promise('\Romchik38\Site2\Application\ArticleView\View\ImageDTOFactory'),
            new Promise('\Romchik38\Site2\Application\ArticleView\View\AudioDTOFactory')
        ]
    );

    return $container;
};
