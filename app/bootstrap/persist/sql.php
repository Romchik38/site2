<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // DATABASES
    $container->multi(
        '\Romchik38\Server\Persist\Sql\DatabasePostgresql',
        '\Romchik38\Server\Persist\Sql\DatabaseSqlInterface',
        true,
        [
            new Promise('database.postgres.connect.main')
        ]
    );

    // ADMIN USER
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser\Repository',
        '\Romchik38\Site2\Application\AdminUser\AdminUserService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ARTICLE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Article\Repository',
        '\Romchik38\Site2\Application\Article\ArticleService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ARTICLE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\List\Repository',
        '\Romchik38\Site2\Application\Article\List\View\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface'),
            new Promise('\Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\List\Commands\Pagination\ImageDTOFactory')
        ]
    );

    // ARTICLE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\View\Repository',
        '\Romchik38\Site2\Application\Article\View\View\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface'),
            new Promise('\Romchik38\Site2\Application\Article\View\View\ArticleViewDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\View\View\ImageDTOFactory'),
            new Promise('\Romchik38\Site2\Application\Article\View\View\AudioDTOFactory'),
        ]
    );

    // ADMIN ARTICLE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminView\Repository',
        '\Romchik38\Site2\Application\Article\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface'),
        ]
    );

    // CATEGORY VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Category\View\Repository',
        '\Romchik38\Site2\Application\Category\View\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface'),
            new Promise('\Romchik38\Site2\Application\Category\View\View\ArticleDtoFactory'),
            new Promise('\Romchik38\Site2\Application\Category\View\View\ImageDtoFactory')
        ]
    );

    // IMAGE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Image\Repository',
        '\Romchik38\Site2\Domain\Image\ImageRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface'),
        ]
    );

    // IMG VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\Converter\ImgViewRepository',
        '\Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN IMAGE LIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminList\Repository',
        '\Romchik38\Site2\Application\Image\AdminImageListService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN IMAGE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Image\AdminView\Repository',
        '\Romchik38\Site2\Application\Image\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // IMAGE CACHE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ImageCache\Repository',
        '\Romchik38\Site2\Domain\ImageCache\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // IMAGE CACHE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ImageCache\ImageCacheView\Repository',
        '\Romchik38\Site2\Application\ImageCache\View\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN ARTICLE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\AdminListView\Repository',
        '\Romchik38\Site2\Application\Article\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN AUTHOR LIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminList\Repository',
        '\Romchik38\Site2\Application\Author\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // ADMIN AUTHOR VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Author\AdminView\Repository',
        '\Romchik38\Site2\Application\Author\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // LANGUAGE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Language\List\Repository',
        '\Romchik38\Site2\Application\Language\List\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // AUTHOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Author\Repository',
        '\Romchik38\Site2\Domain\Author\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO ADMINLIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminList\Repository',
        '\Romchik38\Site2\Application\Audio\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminView\Repository',
        '\Romchik38\Site2\Application\Audio\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO AUDIOSERVICE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Audio\Repository',
        '\Romchik38\Site2\Application\Audio\AudioService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO TRANSLATE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminTranslateView\Repository',
        '\Romchik38\Site2\Application\Audio\AdminTranslateView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // AUDIO TRANSLATE CREATE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Audio\AdminTranslateCreate\Repository',
        '\Romchik38\Site2\Application\Audio\AdminTranslateCreate\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // CATEGORY
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Category\Repository',
        '\Romchik38\Site2\Application\Category\CategoryService\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // CATEGORY ADMIN LIST
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Category\AdminList\Repository',
        '\Romchik38\Site2\Application\Category\AdminList\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // CATEGORY ADMIN VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Category\AdminView\Repository',
        '\Romchik38\Site2\Application\Category\AdminView\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // TRANSLATE STORAGE 
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\TranslateStorage\TranslateStorage',
        '\Romchik38\Server\Utils\Translate\TranslateStorageInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );
    
    // TRANSLATE LIST VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\List\Repository',
        '\Romchik38\Site2\Application\Translate\List\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // TRANSLATE VIEW
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Translate\View\Repository',
        '\Romchik38\Site2\Application\Translate\View\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    // TRANSLATE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\Translate\Repository',
        '\Romchik38\Site2\Domain\Translate\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Persist\Sql\DatabaseSqlInterface')
        ]
    );

    return $container;
};
