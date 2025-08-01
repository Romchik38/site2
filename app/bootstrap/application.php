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
    
    $container->shared('\Romchik38\Site2\Application\Article\List\Commands\Filter\ImageDTOFactory', [
        new Promise('img-folder-frontend')
    ]);

    // ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\View\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\Article\View\View\RepositoryInterface')
        ]
    );
    
    $container->shared('\Romchik38\Site2\Application\Article\View\View\ImageDTOFactory', [
        new Promise('img-folder-frontend')
    ]);
    $container->shared('\Romchik38\Site2\Application\Article\View\View\AudioDTOFactory', [
        new Promise('audio-folder-frontend'),
    ]);

    // ARTICLE MOST VISITED
    $container->shared(
        '\Romchik38\Site2\Application\Article\MostVisited\MostVisited',
        [
            new Promise('\Romchik38\Site2\Application\Article\MostVisited\RepositoryInterface')
        ]
    );

    // ARTICLE SIMILAR
    $container->shared(
        '\Romchik38\Site2\Application\Article\SimilarArticles\SimilarArticles',
        [
            new Promise('\Romchik38\Site2\Application\Article\SimilarArticles\RepositoryInterface')
        ]
    );

    // ARTICLE CONTINUE READING
    $container->shared(
        '\Romchik38\Site2\Application\Article\ContinueReading\ContinueReading',
        [
            new Promise('\Romchik38\Site2\Application\Article\ContinueReading\RepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ContinueReading\ItemRepositoryInterface')
        ]
    );

    // ADMIN ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Article\AdminView\AdminView',
        [
            new Promise('\Romchik38\Site2\Application\Article\AdminView\RepositoryInterface')
        ]
    );

    // ADMIN ARTICLE MOST VISITED
    $container->shared(
        '\Romchik38\Site2\Application\Article\AdminMostVisited\AdminMostVisited',
        [
            new Promise('\Romchik38\Site2\Application\Article\AdminMostVisited\RepositoryInterface')
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

    // ADMIN BANNER SERVISE
    $container->shared(
        '\Romchik38\Site2\Application\Banner\BannerService\BannerService',
        [
            new Promise('\Romchik38\Site2\Application\Banner\BannerService\RepositoryInterface')
        ]
    );

    // ADMIN BANNER LIST
    $container->shared(
        '\Romchik38\Site2\Application\Banner\AdminList\AdminListService',
        [
            new Promise('\Romchik38\Site2\Application\Banner\AdminList\RepositoryInterface')
        ]
    );
    
    // ADMIN BANNER VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Banner\AdminView\AdminView',
        [
            new Promise('\Romchik38\Site2\Application\Banner\AdminView\RepositoryInterface')
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

    // BANNER VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Banner\List\ListService',
        [
            new Promise('\Romchik38\Site2\Application\Banner\List\RepositoryInterface')
        ]
    );

    // CATEGORY VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Category\View\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\Category\View\RepositoryInterface'),
        ]
    );

    $container->shared('\Romchik38\Site2\Application\Category\View\View\ImageDtoFactory', [
        new Promise('img-folder-frontend')
    ]);

    // CATEGORY LIST
    $container->shared(
        '\Romchik38\Site2\Application\Category\List\ListService',
        [
            new Promise('\Romchik38\Site2\Application\Category\List\RepositoryInterface')
        ]
    );

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
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\RepositoryInterface'),
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

    // PAGE
    $container->shared(
        '\Romchik38\Site2\Application\Page\PageService\PageService',
        [
            new Promise('\Romchik38\Site2\Application\Page\PageService\RepositoryInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );

    // PAGE ADMIN LIST
    $container->shared(
        '\Romchik38\Site2\Application\Page\AdminList\AdminList',
        [
            new Promise('\Romchik38\Site2\Application\Page\AdminList\RepositoryInterface')
        ]
    );

    // PAGE ADMIN VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Page\AdminView\AdminView',
        [
            new Promise('\Romchik38\Site2\Application\Page\AdminView\RepositoryInterface')
        ]
    );

    // PAGE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Page\View\ViewService',
        [
            new Promise('\Romchik38\Site2\Application\Page\View\RepositoryInterface')
        ]
    );

    // LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\Language\List\ListService',
        [
            new Promise('\Romchik38\Site2\Application\Language\List\RepositoryInterface')
        ]
    );

    // SEARCH ARTICLE
    $container->shared(
        '\Romchik38\Site2\Application\Search\Article\ArticleSearchService',
        [
            new Promise('\Romchik38\Site2\Application\Search\Article\RepositoryInterface')
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

    // USER CHECK
    $container->shared('\Romchik38\Site2\Application\User\UserCheck\UserCheckService', []);

    return $container;
};
