<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->multi(
        '\Romchik38\Server\Models\Sql\DatabasePostgresql',
        '\Romchik38\Server\Api\Models\DatabaseInterface',
        true,
        [$configDatabase]
    );

    return $container;
};