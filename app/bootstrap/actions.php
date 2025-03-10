<?php

declare(strict_types=1);

return function ($container) {

    $errorConfig = include_once(__DIR__ . '/../config/shared/errors.php');

    // Root
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Root\DynamicAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // ServerError
    $serverErrorResponseFile = $errorConfig['server-error-page']
        ?? throw new RuntimeException('Missing server-error-page config parameter');

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerError\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class),
            $serverErrorResponseFile
        )
    );

    // Sitemap
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\SitemapLinkTreeInterface::class),
            new Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Sitemap\DefaultAction\SitemapDTOFactory,
        )
    );

    // Not found
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\PageNotFound\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );

    // Server Error Example
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\ServerErrorExample\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    // Article
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction
        (
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Application\ArticleListView\ArticleListViewService::class),
            $container->get(Psr\Http\Message\ServerRequestInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class)
        )
    );

    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DynamicAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Application\ArticleView\ArticleViewService::class),
        )
    );

    // Api
    // Userinfo
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Api\Userinfo\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Api\Userinfo\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class)
        )
    );

    // Admin
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\DefaultAction(
            $container->get('admin_view'),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class)
        )
    );
    
     // Admin Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\Admin\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface::class)
        )
    );

    // Admin Users
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Users\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Admin\Users\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );
    
    // GET\Register
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Register\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class)
        )
    );
    
    // Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Login\DefaultAction(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Views\Html\Site2TwigView::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface::class)
        )
    );

    // [POST]
    // Auth Admin
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Psr\Http\Message\ServerRequestInterface::class),
            $container->get(\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class)
        )
    );

    // Auth
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(Psr\Http\Message\ServerRequestInterface::class),
            $container->get(\Romchik38\Site2\Application\User\UserCheck\UserCheckService::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
        )
    );
    
    // Logout
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class)
        )
    );

    // Admin Logout
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction::class,
        new Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class)
        )
    );

    // Admin Api
    // Userinfo
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction::class,
        new \Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction(
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class)
        )
    );

    // Api
    /** Let's add some */

    return $container;
};
