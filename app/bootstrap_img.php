<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function () {
    $container = new Container();
    (require_once(__DIR__ . '/bootstrap/consts.php'))($container);
    (require_once(__DIR__ . '/bootstrap/persist/sql.php'))($container);
    (require_once(__DIR__ . '/bootstrap/persist/session.php'))($container);
    (require_once(__DIR__ . '/bootstrap/persist/filesystem.php'))($container);
    (require_once(__DIR__ . '/bootstrap/application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/utils.php'))($container);

    return $container;
};
