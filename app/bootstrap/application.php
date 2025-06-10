<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Container\Shared;

return function (Container $container) {

    // ARTICLE
    $container->shared(
        '\Romchik38\Site2\Application\Article\ArticleService\ArticleService',
        [
            new Promise('\Romchik38\Site2\Application\Article\ArticleService\RepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );
        
    // ARTICLE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\List\ListService',
        [
            new Promise('\Romchik38\Site2\Application\Article\List\View\RepositoryInterface'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTOFactory',
        [
            new Promise('\Romchik38\Site2\Infrastructure\Utils\DateFormatterUsesDateFormat'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\ReadLengthFormatter')
        ]
    );
    $container->shared('\Romchik38\Site2\Application\Article\List\Commands\Pagination\ImageDTOFactory', [
        new Promise('img-folder-frontend')
    ]);

    // ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\View\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\Article\View\View\RepositoryInterface')
        ]
    );

    $container->shared('\Romchik38\Site2\Application\Article\View\View\ArticleViewDTOFactory', [
        new Promise('\Romchik38\Site2\Infrastructure\Utils\DateFormatterUsesDateFormat'),
        new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
    ]);
    
    $container->shared('\Romchik38\Site2\Application\Article\View\View\ImageDTOFactory', [
        new Promise('img-folder-frontend')
    ]);
    $container->shared('\Romchik38\Site2\Application\Article\View\View\AudioDTOFactory', [
        new Promise('audio-folder-frontend'),
    ]);

    // ADMIN ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\AdminView\AdminView',
        [
            new Promise('\Romchik38\Site2\Application\Article\AdminView\RepositoryInterface')
        ]
    );

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
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
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

    // ADMIN CATEGORY LIST
    $container->shared(
        '\Romchik38\Site2\Application\Category\AdminList\AdminList',
        [
            new Promise('\Romchik38\Site2\Application\Category\AdminList\RepositoryInterface')
        ]
    );

    // ADMIN CATEGORY VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Category\AdminView\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\Category\AdminView\RepositoryInterface')
        ]
    );

    // ADMIN USER
    $container->shared(
        '\Romchik38\Site2\Application\AdminUser\AdminUserService\AdminUserService',
        [
            new Promise('\Romchik38\Site2\Application\AdminUser\AdminUserService\RepositoryInterface')
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
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageStorageInterface')
        ]
    );

    // IMAGE CONVERTER
    $container->shared(
        '\Romchik38\Site2\Application\Image\ImgConverter\ImgConverterService',
        [
            new Promise('\Romchik38\Site2\Application\Image\ImgConverter\View\ImgViewRepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImgConverter\ImageStorageInterface'),
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
            new Promise('\Romchik38\Site2\Domain\ImageCache\RepositoryInterface')
        ]
    );

    // IMAGE CACHE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\ImageCache\View\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\ImageCache\View\RepositoryInterface')
        ]
    );
 
    // ADMIN ARTICLE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\AdminList\AdminListService',
        [
            new Promise('\Romchik38\Site2\Application\Article\AdminList\RepositoryInterface')
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
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );

    // CATEGORY SERVICE
    $container->shared(
        '\Romchik38\Site2\Application\Category\CategoryService\CategoryService',
        [
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\RepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );

    // LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Language\List\ListService',
        [
            new Promise('\Romchik38\Site2\Application\Language\List\RepositoryInterface')
        ]
    );

    // TRANSLATE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Translate\List\ListService',
        [
            new Promise('\Romchik38\Site2\Application\Translate\List\RepositoryInterface')
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
