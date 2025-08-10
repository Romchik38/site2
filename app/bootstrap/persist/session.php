<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container): Container {

    // SESSION
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2Session',
        '\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface',
        true,
        []
    );

    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Session\Article\ContinueReading\Repository',
        '\Romchik38\Site2\Application\Article\ContinueReading\ItemRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface')
        ]
    );

    // ADMIN VISITOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Session\AdminVisitor\Repository',
        '\Romchik38\Site2\Application\AdminVisitor\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    // VISITOR
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Session\Visitor\Repository',
        '\Romchik38\Site2\Application\Visitor\RepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Utils\TokenGenerators\CsrfTokenGeneratorInterface'),
        ]
    );

    return $container;
};