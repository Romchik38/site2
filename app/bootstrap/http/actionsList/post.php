<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Controllers\ControllerInterface;
use Romchik38\Server\Api\Services\Mappers\ControllerTreeInterface;
use Romchik38\Server\Controllers\Controller;

return function (Container $container): ControllerInterface {
    /** POST */
    $root = new Controller(ControllerTreeInterface::ROOT_NAME);

    // Auth
    $auth = new Controller('auth');
    $authAdmin = new Controller(
        'admin',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Auth\Admin\DefaultAction::class),
        null,
        'auth_admin'
    );
    $auth->setChild($authAdmin);

    // Admin
    $admin = new Controller('admin');
    $adminLogout = new Controller(
        'logout',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Logout\DefaultAction::class),
        null,
        'admin_logout'
    );

    $adminApi = new Controller('api');
    $adminApiUserunfo = new Controller(
        'userinfo',
        false,
        $container->get(\Romchik38\Site2\Infrastructure\Controllers\Actions\POST\Admin\Api\Userinfo\DefaultAction::class)
    );
    $adminApi->setChild($adminApiUserunfo);

    $admin->setChild($adminLogout)->setChild($adminApi);

    $root->setChild($auth)->setChild($admin);
    return $root;
};