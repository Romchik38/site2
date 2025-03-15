<?php

declare(strict_types=1);

return function ($container) {

    $errorConfig = include_once(__DIR__ . '/../config/shared/errors.php');

    // Root
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        )
    );
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        )
    );

    // ServerError
    $serverErrorResponseFile = $errorConfig['server-error-page']
        ?? throw new RuntimeException('Missing server-error-page config parameter');

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface'),
            $serverErrorResponseFile
        )
    );

    // Sitemap
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\SitemapLinkTreeInterface'),
            new Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory,
        )
    );

    // Not found
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface')
        )
    );

    // Server Error Example
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        )
    );

    // Article
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction
        (
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Site2\Application\ArticleListView\ArticleListViewService'),
            $container->get('\Psr\Http\Message\ServerRequestInterface'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        )
    );

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Site2\Application\ArticleView\ArticleViewService'),
        )
    );

    // Api
    // Userinfo
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Api\Userinfo\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Api\Userinfo\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        )
    );

    // Admin
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction(
            $container->get('admin_view'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        )
    );
    
     // Admin Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        )
    );

    // Admin Users
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Users\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Users\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
        )
    );
    
    // GET\Register
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView')
        )
    );
    
    // Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface')
        )
    );

    // [POST]
    // Auth Admin
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Psr\Http\Message\ServerRequestInterface'),
            $container->get('\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface')
        )
    );

    // Auth
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Psr\Http\Message\ServerRequestInterface'),
            $container->get('\Romchik38\Site2\Application\User\UserCheck\UserCheckService'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
        )
    );
    
    // Logout
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        )
    );

    // Admin Logout
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction::class,
        new Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        )
    );

    // Admin Api
    // Userinfo
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction(
            $container->get('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface'),
            $container->get('\Romchik38\Server\Api\Services\Translate\TranslateInterface'),
            $container->get('\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface')
        )
    );

    // Api
    /** Let's add some */

    return $container;
};
