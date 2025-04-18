<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->multi(
        '\Romchik38\Server\Models\Sql\DatabasePostgresql',
        '\Romchik38\Server\Models\Sql\DatabaseSqlInterface',
        true,
        [$configDatabase]
    );

    // ADMIN USER
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser\AdminUserRepository',
        '\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // ARTICLE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ListView\ArticleListViewRepository',
        '\Romchik38\Site2\Application\Article\ArticleListView\View\ArticleListViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\View\ArticleDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\View\ImageDTOFactory')
        ]
    );

    // ARTICLE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\View\ArticleViewRepository',
        '\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\ImageDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\AudioDTOFactory')
        ]
    );

    // IMAGE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Image\Repository',
        '\Romchik38\Site2\Domain\Image\ImageRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface'),
        ]
    );

    // IMG VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\Converter\ImgViewRepository',
        '\Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN IMAGE LIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminList\Repository',
        '\Romchik38\Site2\Application\Image\AdminImageListService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN IMAGE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminView\Repository',
        '\Romchik38\Site2\Application\Image\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // IMAGE CACHE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ImageCache\ImageCacheRepository',
        '\Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // IMAGE CACHE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImageCache\ImageCacheView\ImageCacheViewRepository',
        '\Romchik38\Site2\Application\ImageCache\ImageCacheView\View\ImageCacheViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN ARTICLE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminListView\Repository',
        '\Romchik38\Site2\Application\Article\AdminArticleListView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN AUTHOR LIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminList\Repository',
        '\Romchik38\Site2\Application\Author\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN AUTHOR VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView\Repository',
        '\Romchik38\Site2\Application\Author\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // LANGUAGE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Language\ListView\Repository',
        '\Romchik38\Site2\Application\Language\ListView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // AUTHOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Author\Repository',
        '\Romchik38\Site2\Domain\Author\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO ADMINLIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminList\Repository',
        '\Romchik38\Site2\Application\Audio\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminView\Repository',
        '\Romchik38\Site2\Application\Audio\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO AUDIOSERVICE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Audio\Repository',
        '\Romchik38\Site2\Application\Audio\AudioService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO TRANSLATE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminTranslateView\Repository',
        '\Romchik38\Site2\Application\Audio\AdminTranslateView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO TRANSLATE CREATE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminTranslateCreate\Repository',
        '\Romchik38\Site2\Application\Audio\AdminTranslateCreate\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // TRANSLATE STORAGE 
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\TranslateStorage\TranslateStorage',
        '\Romchik38\Server\Services\Translate\TranslateStorageInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );
    
    // TRANSLATE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\ListView\Repository',
        '\Romchik38\Site2\Application\Translate\ListView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // TRANSLATE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\View\Repository',
        '\Romchik38\Site2\Application\Translate\View\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    // TRANSLATE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Translate\Repository',
        '\Romchik38\Site2\Domain\Translate\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Models\Sql\DatabaseSqlInterface')
        ]
    );

    return $container;
};
