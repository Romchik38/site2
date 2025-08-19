<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // Root
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Banner\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Article\List\ListService'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Page\View\ViewService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // Category
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Category\View\ViewService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\List\ListService'),
            new Promise('\Romchik38\Site2\Application\Article\MostVisited\MostVisited'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Category\List\ListService')
        ]
    );

    // Sitemap
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\SitemapLinkTreeInterface'),
            new Promise ('\Romchik38\Site2\Application\Page\View\ViewService'),
        ]
    );

    // Server Error Example
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerErrorExample\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
        ]
    );

    // Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Article\List\ListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\List\ListService'),
            new Promise('\Romchik38\Site2\Application\Article\MostVisited\MostVisited'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Article\View\ViewService'),
            new Promise('\Romchik38\Site2\Application\Article\SimilarArticles\SimilarArticles'),
        ]
    );

    // Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\DefaultAction',
        [
            new Promise('backend-view'),
        ]
    );

    // Admin Audio
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminList\AdminList'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminView\AdminView'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('audio-folder-frontend'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
    
    // ADMIN AUDIO NEW 
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
        ]
    );

    // ADMIN AUDIO TRANSLATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateView\AdminTranslateView'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('audio-folder-frontend'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN AUDIO TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateCreate\AdminTranslateCreate'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),    
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
    
    // Admin Banner
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Banner\AdminList\AdminListService'),    
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Banner\AdminView\AdminView'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN BANNER NEW 
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Article\AdminList\AdminListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Site2\Application\Article\AdminView\AdminView'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('audio-folder-frontend'),
            new Promise('\Romchik38\Site2\Application\Category\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Article New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
        ]
    );

    // Admin Article Most Visited
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\MostVisited\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Article\AdminMostVisited\AdminMostVisited'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Category
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Category\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Category\AdminView\ViewService'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Category New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]

    );

    // Admin Image cache
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Image
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Image\AdminImageListService\AdminImageListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );
    
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Image New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Author
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AdminList\AdminAuthorList'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Author\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );    

    // ADMIN AUTHOR NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
        ]
    );

    // ADMIN LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Language\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );

    // ADMIN PAGE LIST
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Page\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN PAGE VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Page\AdminView\AdminView'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN PAGE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Page\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN TRANSLATE LIST
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN TRANSLATE VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Translate\View\ViewService'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // ADMIN TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
        ]
    );

    // Admin Users
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Users\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('backend-view'),
        ]
    );
        
    // Account
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Account\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Page\View\ViewService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ContinueReading\ContinueReading'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );
    
    // Register
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Register\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Page\View\ViewService'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );
    
    // Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Page\View\ViewService'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );

    // Search
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Search\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('frontend-view'),
            new Promise('\Romchik38\Site2\Application\Search\Article\ArticleSearchService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
        ]
    );

    // [POST]
    // API
    // USERINFO
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\Userinfo\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ARTICLEVIEWS
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleViews\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleViews\ArticleViewsService'),
        ]
    );

    // ARTICLE CONTINUE READING
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ContinueReading\ContinueReading'),
        ]        
    );

    // ARTICLE CONTINUE READING UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\ArticleContinueReading\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ContinueReading\ContinueReading'),
        ]        
    );    

    // ADMIN ARTICLE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\Delete\DefaultAction',
         [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleService\ArticleService')
        ]
    );

    // ADMIN ARTICLE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleService\ArticleService')
        ]
    );

    // ADMIN ARTICLE UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleService\ArticleService')
        ]
    );

    // ADMIN ARTICLE MOST VISITED CLEAR
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\MostVisited\Clear\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleService\ArticleService')
        ]
    );

    // ADMIN AUDIO DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN AUDIO NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),            
        ]
    );

    // ADMIN AUDIO UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),            
        ]
    );

    // ADMIN AUDIO TRANSLATE UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN AUDIO TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );
    
    // ADMIN AUDIO TRANSLATE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN AUTHOR UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\AuthorService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
        ]
    );

    // ADMIN AUTHOR NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\AuthorService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
        ]
    );

    // ADMIN AUTHOR DELETE
    $container->shared(
        'Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\AuthorService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN BANNER DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Banner\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\BannerService\BannerService'),            
        ]
    );

    // ADMIN BANNER NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Banner\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\BannerService\BannerService'),
        ]
    );

    // ADMIN BANNER UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Banner\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\BannerService\BannerService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),            
        ]
    );

    // ADMIN CATEGORY DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\CategoryService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN CATEGORY NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\CategoryService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN CATEGORY UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\CategoryService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // Admin Image Update
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageService'),
           new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
        ]
    );

    // Admin image new
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
        ]
    );
    
    // Admin Image Delete
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // Admin Image Cache Clear
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Imagecache\Clear\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );
    
    // Admin Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );

    // ADMIN PAGE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Page\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Page\PageService\PageService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),            
        ]
    );

    // ADMIN PAGE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Page\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Page\PageService\PageService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN PAGE UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Page\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Page\PageService\PageService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN TRANSLATE UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\TranslateService\TranslateService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\TranslateService\TranslateService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN TRANSLATE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\TranslateService\TranslateService'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // Auth Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\AdminUser\AdminUserService\AdminUserService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\AdminVisitor\AdminVisitorService'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );

    // Auth
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\User\UserCheck\UserCheckService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );
    
    // Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Visitor\VisitorService'),
        ]
    );
    
    return $container;
};
