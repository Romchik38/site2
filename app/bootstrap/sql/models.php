<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->multi(
        '\Romchik38\Server\Models\Sql\DatabasePostgresql',
        '\Romchik38\Server\Models\Sql\DatabaseInterface',
        true,
        [$configDatabase]
    );
    
    // TRANSLATE ENTITY MODEL REPOSITORY
    $container->multi(
        '\Romchik38\Server\Models\TranslateEntity\Sql\TranslateEntityModelRepository',
        '\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface'),
            new Promise('\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface'),
            'translate_entities',
            'entity_id'
        ]
    );

    // ADMIN USER REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser\AdminUserRepository',
        '\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // ARTICLE LIST VIEW REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ListView\ArticleListViewRepository',
        '\Romchik38\Site2\Application\Article\ArticleListView\View\ArticleListViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\View\ArticleDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\View\ImageDTOFactory')
        ]
    );

    // ARTICLE VIEW REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\View\ArticleViewRepository',
        '\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\ImageDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\AudioDTOFactory')
        ]
    );

    // IMG VIEW REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\Converter\ImgViewRepository',
        '\Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // ADMIN IMAGE LIST REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminList\Repository',
        '\Romchik38\Site2\Application\Image\AdminImageListService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // IMAGE CACHE REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ImageCache\ImageCacheRepository',
        '\Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // Image Cache View Repository
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImageCacheView\ImageCacheViewRepository',
        '\Romchik38\Site2\Application\ImageCacheView\View\ImageCacheViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // ADMIN ARTICLE LIST VIEW REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminListView\Repository',
        '\Romchik38\Site2\Application\Article\AdminArticleListView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // ADMIN AUTHOR LIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminList\Repository',
        '\Romchik38\Site2\Application\Author\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // ADMIN AUTHOR VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView\Repository',
        '\Romchik38\Site2\Application\Author\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // LANGUAGE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Language\ListView\Repository',
        '\Romchik38\Site2\Application\Language\ListView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    // AUTHOR REPOSITORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Author\Repository',
        '\Romchik38\Site2\Domain\Author\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseInterface')
        ]
    );

    return $container;
};
