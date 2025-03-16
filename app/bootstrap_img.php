<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function () {
    $container = new Container();

    (require_once(__DIR__ . '/bootstrap/models.php'))($container);
    (require_once(__DIR__ . '/bootstrap/sql/models.php'))($container);
    (require_once(__DIR__ . '/bootstrap/application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/services.php'))($container);

    return $container;
};
