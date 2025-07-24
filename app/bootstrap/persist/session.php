<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container): Container {

    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Session\Article\ContinueReading\Repository',
        '\Romchik38\Site2\Application\Article\ContinueReading\ItemRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Site2\Infrastructure\Http\Services\Session\Site2SessionInterface')
        ]
    );

    return $container;
};