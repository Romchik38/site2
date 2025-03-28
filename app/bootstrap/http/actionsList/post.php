<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container): ControllerInterface {
    /** POST */
    $root = new Controller(ControllerTreeInterface::ROOT_NAME);

    // Auth
    $auth = new Controller(
        'auth', 
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\DefaultAction')
    );
    $auth->addRequestMiddleware($container->get('\Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\CsrfMiddleware'));
    
    $authAdmin = new Controller(
        'admin',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction'),
        null,
        'auth_admin'
    );
    $auth->setChild($authAdmin);

    // Logout
    $logout = new Controller(
        'logout',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Logout\DefaultAction')
    );

    // Api
    $api = new Controller('api');
    $apiUserinfo = new Controller(
        'userinfo',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Api\Userinfo\DefaultAction')
    );
    $api->setChild($apiUserinfo);

    // Admin
    $admin = new Controller('admin');
    $admin->addRequestMiddleware($container->get('\Romchik38\Site2\Infrastructure\Controllers\RequestMiddlewares\Admin\AdminLoginMiddleware'));

    $adminLogout = new Controller(
        'logout',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction'),
        null,
        'admin_logout'
    );

    // Admin Api
    $adminApi = new Controller('api');
    $adminApiUserunfo = new Controller(
        'userinfo',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction')
    );
    $adminApi->setChild($adminApiUserunfo);

    // Admin Image Cache
    $adminImagecache = new Controller('imagecache', false);
    $adminImagecacheClear = new Controller(
        'clear',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Imagecache\Clear\DefaultAction')
    );
    $adminImagecacheClear->addRequestMiddleware($container->get('request-middleware.csrf.admin'));
    $adminImagecache->setChild($adminImagecacheClear);

    // Admin Author
    $adminAuthor = new Controller('author');
    $adminAuthorUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Author\Update\DefaultAction'),
        null,
        'author_update'
    );
    $adminAuthorNew = new Controller(
        'new',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Author\New\DefaultAction'),
        null,
        'author_new'
    );
    $adminAuthorDelete = new Controller(
        'delete',
        false,
        $container->get('Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Author\Delete\DefaultAction'),
        null,
        'author_delete'
    );
    $adminAuthor
    ->setChild($adminAuthorUpdate)
    ->setChild($adminAuthorNew)
    ->setChild($adminAuthorDelete)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));

    $adminTranslate = new Controller('translate');
    $adminTranslateUpdate = new Controller(
        'update',
        false,
        $container->get('\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Translate\Update\DefaultAction'),
        null,
        'translate_update'
    );
    $adminTranslate->setChild($adminTranslateUpdate)
    ->addRequestMiddleware($container->get('request-middleware.csrf.admin'));

    $admin->setChild($adminLogout)
    ->setChild($adminApi)
    ->setChild($adminImagecache)
    ->setChild($adminAuthor)
    ->setChild($adminTranslate);

    $root->setChild($auth)
    ->setChild($admin)
    ->setChild($api)
    ->setChild($logout);

    return $root;
};