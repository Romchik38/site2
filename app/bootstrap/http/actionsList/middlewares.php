<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container): void {
    // Admin Login
    $container->add(
        \Romchik38\Site2\Infrastructure\Controllers\Middlewares\Admin\AdminLoginMiddleware::class,
        /** 
         * @todo this is because only of container implementation 
         * */
        function($container) {
            return new \Romchik38\Site2\Infrastructure\Controllers\Middlewares\Admin\AdminLoginMiddleware(
                $container->get(\Romchik38\Site2\Infrastructure\Services\Session\Site2SessionInterface::class),
                $container->get(\Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface::class)
            );
        }
    );
};