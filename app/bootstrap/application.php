<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $configImg = require_once(__DIR__ . '/../config/shared/images.php');
    $configImgFolderFrontend =  $configImg['img-folder-frontend'] ??
        throw new RuntimeException('Missing config field: img-folder-frontend');

    $configImgFolderBackend =  $configImg['img-folder-backend'] ??
        throw new RuntimeException('Missing config field: img-folder-backend');

    $configAudio = require_once(__DIR__ . '/../config/shared/audio.php');
    $configAudioFolderFrontend =  $configAudio['audio-folder-frontend'] ??
        throw new RuntimeException('Missing config field: audio-folder-frontend');

    // ARTICLE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\ArticleListView\ArticleListViewService',
        [
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\View\ArticleListViewRepositoryInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ListView\SearchCriteriaFactory')
        ]
    );

    $container->shared('\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ListView\SearchCriteriaFactory', []);

    $container->shared(
        '\Romchik38\Site2\Application\Article\ArticleListView\View\ArticleDTOFactory',
        [
            new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter')
        ]
    );
    $container->shared('\Romchik38\Site2\Application\Article\ArticleListView\View\ImageDTOFactory', [$configImgFolderFrontend]);

    // ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\ArticleView\ArticleViewService',
        [
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewRepositoryInterface')
        ]
    );

    $container->shared('\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewDTOFactory', [
        new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
        new Promise('\Romchik38\Server\Services\Translate\TranslateInterface')
    ]);
    
    $container->shared('\Romchik38\Site2\Application\Article\ArticleView\View\ImageDTOFactory', [$configImgFolderFrontend]);
    $container->shared('\Romchik38\Site2\Application\Article\ArticleView\View\AudioDTOFactory', [$configAudioFolderFrontend]);

    // ADMIN USER CHECK
    $container->shared(
        '\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService',
        [
            new Promise('\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInterface')
        ]
    );

    // ADMIN USER ROLES
    $container->shared(
        '\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService',
        [
            new Promise('\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInterface')
        ]
    );

    // USER CHECK
    $container->shared('\Romchik38\Site2\Application\User\UserCheck\UserCheckService', []);

    // IMAGE CONVERTER
    $container->shared(
        '\Romchik38\Site2\Application\Image\ImgConverter\ImgConverterService',
        [
            new Promise('\Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface'),
            $configImgFolderBackend,
            new Promise('\Romchik38\Site2\Application\Image\ImgConverter\ImgConverterInterface')
        ]
    );

    // ADMIN IMAGE LIST
    $container->shared(
        '\Romchik38\Site2\Application\Image\AdminImageListService\AdminImageListService',
        [
            new Promise('\Romchik38\Site2\Application\Image\AdminImageListService\RepositoryInterface')
        ]
    );

    // IMAGE CACHE
    $container->shared(
        '\Romchik38\Site2\Application\ImageCache\ImageCacheService',
        [
            new Promise('\Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface')
        ]
    );

    // IMAGE CACHE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\ImageCacheView\ImageCacheViewService',
        [
            new Promise('\Romchik38\Site2\Application\ImageCacheView\View\ImageCacheViewRepositoryInterface')
        ]
    );
 
    // ADMIN ARTICLE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\AdminArticleListView\AdminArticleListViewService',
        [
            new Promise('\Romchik38\Site2\Application\Article\AdminArticleListView\RepositoryInterface')
        ]
    );

    // ADMIN AUTHOR LIST
    $container->shared(
        '\Romchik38\Site2\Application\Author\AdminList\AdminAuthorList',
        [
            new Promise('\Romchik38\Site2\Application\Author\AdminList\RepositoryInterface')
        ]
    );

    // ADMIN AUTHOR VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Author\AdminView\AdminViewService',
        [
            new Promise('\Romchik38\Site2\Application\Author\AdminView\RepositoryInterface')
        ]
    );

    // AUTHOR SERVICE
    $container->shared(
        '\Romchik38\Site2\Application\Author\AuthorService\AuthorService',
        [
            new Promise('\Romchik38\Site2\Domain\Author\RepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService')
        ]
    );

    // LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Language\ListView\ListViewService',
        [
            new Promise('\Romchik38\Site2\Application\Language\ListView\RepositoryInterface')
        ]
    );

    // TRANSLATE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Translate\ListView\ListViewService',
        [
            new Promise('\Romchik38\Site2\Application\Translate\ListView\RepositoryInterface')
        ]
    );

    return $container;
};
