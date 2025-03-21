<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $errorConfig = include_once(__DIR__ . '/../config/shared/errors.php');

    // Root
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        ]
    );

    // ServerError
    $serverErrorResponseFile = $errorConfig['server-error-page'] ?? 
        throw new RuntimeException('Missing server-error-page config parameter');

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface'),
            $serverErrorResponseFile
        ]
    );

    // Sitemap
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\SitemapLinkTreeInterface'),
            new Promise ('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory')
        ]
    );
    $container->shared('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory');

    // Not found
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        ]
    );

    // Server Error Example
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        ]
    );

    // Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleListView\ArticleListViewService'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Application\Article\ArticleView\ArticleViewService'),
        ]
    );

    // Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction',
        [
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );
    
     // Admin Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // Admin Users
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Users\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view')
        ]
    );

    // Admin Article
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Article\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Article\AdminArticleListView\AdminArticleListViewService'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    // Admin Image cache
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Imagecache\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // Admin Image
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Image\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Image\AdminImageListService\AdminImageListService'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );
    
    // Admin Author
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Application\Author\AdminList\AdminAuthorList')
        ]
    );

    // ADMIN LANGUAGE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Language\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Language\ListView\ListViewService')
        ]
    );

    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Author\DynamicAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('admin_view'),
            new Promise('\Romchik38\Site2\Application\Author\AdminView\AdminViewService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // Register
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView')
        ]
    );
    
    // Login
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        ]
    );

    // [POST]
    // Api
    // Userinfo
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Api\Userinfo\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    // Auth Admin
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    // Auth
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Psr\Http\Message\ServerRequestInterface'),
            new Promise('\Romchik38\Site2\Application\User\UserCheck\UserCheckService'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        ]
    );
    
    // Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    // Admin Logout
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    // Admin Image Cache Clear
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Imagecache\Clear\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Application\ImageCache\ImageCacheService'),
            new Promise('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        ]
    );

    // Admin Api
    // Userinfo
    $container->shared(
        '\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction',
        [
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        ]
    );

    return $container;
};
