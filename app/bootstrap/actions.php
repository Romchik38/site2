<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // Root
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Root\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerError\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface'),
            new Promise('server-error-page'),
        ]
    );

    // Sitemap
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\SitemapLinkTreeInterface'),
            new Promise ('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory'),
        ]
    );
    $container->shared('\Romchik38\Site2\Infrastructure\Http\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory');

    // Not found
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\PageNotFound\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        ]
    );

    // Server Error Example
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\ServerErrorExample\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface')
        ]
    );

    // Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\ArticleListViewService'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Article\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\ArticleViewService'),
        ]
    );

    // Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\DefaultAction',
        [
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    // Admin Audio
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminView\AdminView'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('audio-folder-frontend')
        ]
    );
    
    // ADMIN AUDIO NEW 
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    // ADMIN AUDIO TRANSLATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateView\AdminTranslateView'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
            new Promise('audio-folder-frontend')
        ]
    );

    // ADMIN AUDIO TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Audio\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AdminTranslateCreate\AdminTranslateCreate'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),                
        ]
    );

    // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // Admin Users
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Users\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
        ]
    );

    // Admin Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Article\AdminArticleListView\AdminArticleListViewService'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        ]
    );

    // Admin Category
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Category\AdminList\AdminList'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Category\AdminView\ViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        ]
    );

    // Admin Category New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Category\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        ]

    );

    // Admin Image cache
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Imagecache\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // Admin Image
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Image\AdminImageListService\AdminImageListService'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );
    
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    // Admin Image New
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Image\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Image\AdminView\AdminViewService')
        ]
    );

    // Admin Author
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AdminList\AdminAuthorList'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // ADMIN AUTHOR NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService')
        ]
    );

    // ADMIN LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Language\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Author\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Author\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService')
        ]
    );

    // ADMIN TRANSLATE LIST
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\ListView\ListViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN TRANSLATE VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Translate\View\ViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Admin\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService'),
        ]
    );

    // Register
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Register\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView')
        ]
    );
    
    // Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\GET\Login\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Http\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // [POST]
    // Api
    // Userinfo
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Api\Userinfo\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    // Admin Api
    // Userinfo
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Api\Userinfo\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    // ADMIN AUDIO DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN AUDIO NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),            
        ]
    );

    // ADMIN AUDIO UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),            
        ]
    );

    // ADMIN AUDIO TRANSLATE UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN AUDIO TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );
    
    // ADMIN AUDIO TRANSLATE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Audio\Translate\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Audio\AudioService\AudioService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN AUTHOR UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\AuthorService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // ADMIN AUTHOR NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\AuthorService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // ADMIN AUTHOR DELETE
    $container->shared(
        'Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Author\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AuthorService\AuthorService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN CATEGORY DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\CategoryService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN CATEGORY NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\CategoryService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // ADMIN CATEGORY UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Category\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Category\CategoryService\CategoryService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface'),
        ]
    );

    // Admin Image Update
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // Admin image new
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );
    
    // Admin Image Delete
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Image\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Image\ImageService\ImageService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // Admin Image Cache Clear
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Imagecache\Clear\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );
    
    // Admin Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
        ]
    );

    // ADMIN TRANSLATE UPDATE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Update\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\TranslateService\TranslateService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // ADMIN TRANSLATE NEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\New\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\TranslateService\TranslateService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // ADMIN TRANSLATE DELETE
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Admin\Translate\Delete\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\Translate\TranslateService\TranslateService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Api\Services\LoggerServerInterface')
        ]
    );

    // Auth Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    // Auth
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Auth\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\User\UserCheck\UserCheckService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        ]
    );
    
    // Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Http\Actions\POST\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );
    
    return $container;
};
