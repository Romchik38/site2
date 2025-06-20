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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Application\Banner\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Server\Http\Views\Dto\DefaultViewDTOFactoryInterface'),
        ]
    );

    // Category
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Application\Category\View\ViewService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\List\ListService'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Application\Category\List\ListService')
        ]
    );

    // Sitemap
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\SitemapLinkTreeInterface'),
            new Promise ('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory'),
        ]
    );
    $container->shared('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory');

    // Server Error Example
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerErrorExample\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface')
        ]
    );

    // Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Application\Article\List\ListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\List\ListService')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Application\Article\View\ViewService'),
        ]
    );

    // Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\DefaultAction',
        [
            new Promise('admin_view_layout'),
        ]
    );

    // Admin Audio
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminView\AdminView'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('audio-folder-frontend')
        ]
    );
    
    // ADMIN AUDIO NEW 
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    // ADMIN AUDIO TRANSLATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateView\AdminTranslateView'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('audio-folder-frontend')
        ]
    );

    // ADMIN AUDIO TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateCreate\AdminTranslateCreate'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),    
        ]
    );
    
    // Admin Banner
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Banner\AdminList\AdminListService'),    
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Banner\AdminView\AdminView'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
        ]
    );

    // ADMIN BANNER NEW 
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Banner\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // Admin Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Article\AdminList\AdminListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Site2\Application\Article\AdminView\AdminView'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('audio-folder-frontend'),
            new Promise('\Romchik38\Site2\Application\Category\AdminList\AdminList')
        ]
    );

    // Admin Article New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    // Admin Category
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Category\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Category\AdminView\ViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
        ]
    );

    // Admin Category New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
        ]

    );

    // Admin Image cache
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
        ]
    );

    // Admin Image
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Image\AdminImageListService\AdminImageListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );
    
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface')
        ]
    );

    // Admin Image New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\AdminViewService')
        ]
    );

    // Admin Author
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AdminList\AdminAuthorList'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Author\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );    

    // ADMIN AUTHOR NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );

    // ADMIN LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Language\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService')
        ]
    );

    // ADMIN TRANSLATE LIST
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\List\ListService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN TRANSLATE VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DynamicAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Application\Translate\View\ViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // ADMIN TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\List\ListService'),
        ]
    );

    // Admin Users
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Users\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('admin_view_layout'),
        ]
    );
        
    // Register
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Register\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout')
        ]
    );
    
    // Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigViewLayout'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface')
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
        ]
    );

    // ADMIN ARTICLE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Article\Delete\DefaultAction',
         [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleService\ArticleService')
        ]
    );

    // ADMIN API
    // USERINFO
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Api\Userinfo\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // Admin Image Cache Clear
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Imagecache\Clear\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface')
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
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
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface'),
        ]
    );

    // Auth
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Application\User\UserCheck\UserCheckService'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
        ]
    );
    
    // Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Utils\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface')
        ]
    );
    
    return $container;
};
