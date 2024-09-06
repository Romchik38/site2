<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {
    $configDatabase = require_once(__DIR__ . '/../../config/private/database.php');

    // DATABASES
    $container->add(
        \Romchik38\Server\Models\Sql\DatabasePostgresql::class,
        new \Romchik38\Server\Models\Sql\DatabasePostgresql($configDatabase)
    );
    $container->add(
        \Romchik38\Server\Api\Models\DatabaseInterface::class,
        $container->get(\Romchik38\Server\Models\Sql\DatabasePostgresql::class)
    );

    return $container;
};
