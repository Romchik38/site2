<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

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
    $container->shared('\Romchik38\Site2\Application\Article\ArticleListView\View\ImageDTOFactory', [
        new Promise('img-folder-frontend')
    ]);

    // ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\ArticleView\ArticleViewService',
        [
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewRepositoryInterface')
        ]
    );

    $container->shared('\Romchik38\Site2\Application\Article\ArticleView\View\ArticleViewDTOFactory', [
        new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
        new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
    ]);
    
    $container->shared('\Romchik38\Site2\Application\Article\ArticleView\View\ImageDTOFactory', [
        new Promise('img-folder-frontend')
    ]);
    $container->shared('\Romchik38\Site2\Application\Article\ArticleView\View\AudioDTOFactory', [
        new Promise('audio-folder-frontend'),
    ]);

    // ADMIN AUDIO LIST
    $container->shared(
        '\Romchik38\Site2\Application\Audio\AdminList\AdminList',
        [
            new Promise('\Romchik38\Site2\Application\Audio\AdminList\RepositoryInterface'),
        ]
    );

    // ADMIN AUDIO SERVICE
    $container->shared(
        '\Romchik38\Site2\Application\Audio\AudioService\AudioService',
        [
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\RepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioStorageInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
        ]
    );

    // ADMIN AUDIO VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Audio\AdminView\AdminView',
        [
            new Promise('\Romchik38\Site2\Application\Audio\AdminView\RepositoryInterface')
        ]
    );

    // ADMIN AUDIO TRANSLATE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Audio\AdminTranslateView\AdminTranslateView',
        [
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateView\RepositoryInterface')
        ]
    );

    // ADMIN AUDIO TRANSLATE CREATE
    $container->shared(
        '\Romchik38\Site2\Application\Audio\AdminTranslateCreate\AdminTranslateCreate',
        [
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateCreate\RepositoryInterface')
        ]
    );

    // ADMIN CATEGORY
    $container->shared(
        '\Romchik38\Site2\Application\Category\AdminList\AdminList',
        [
            new Promise('\Romchik38\Site2\Application\Category\AdminList\RepositoryInterface')
        ]
    );

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

    // IMAGE
    $container->shared(
        '\Romchik38\Site2\Application\Image\ImageService\ImageService',
        [
            new Promise('\Romchik38\Site2\Domain\Image\ImageRepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\CreateContentServiceInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageStorageInterface')
        ]
    );

    // IMAGE CONVERTER
    $container->shared(
        '\Romchik38\Site2\Application\Image\ImgConverter\ImgConverterService',
        [
            new Promise('\Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface'),
            new Promise('img-folder-backend'),
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

    // ADMIN IMAGE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Image\AdminView\AdminViewService',
        [
            new Promise('\Romchik38\Site2\Application\Image\AdminView\RepositoryInterface'),
            new Promise('img-folder-backend'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\ImageMetadataLoaderInterface'),
            new Promise('img-folder-frontend')
        ]
    );

    // IMAGE CACHE
    $container->shared(
        '\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService',
        [
            new Promise('\Romchik38\Site2\Domain\ImageCache\ImageCacheRepositoryInterface')
        ]
    );

    // IMAGE CACHE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\ImageCache\ImageCacheView\ImageCacheViewService',
        [
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheView\View\ImageCacheViewRepositoryInterface')
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

    // TRANSLATE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Translate\View\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\Translate\View\RepositoryInterface')
        ]
    );

    // TRANSLATE SERVICE
    $container->shared(
        '\Romchik38\Site2\Application\Translate\TranslateService\TranslateService',
        [
            new Promise('\Romchik38\Site2\Domain\Translate\RepositoryInterface')
        ]
    );

    return $container;
};
