<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    
    /** Order does not matter till 1st container get */
    (require_once(__DIR__ . '/bootstrap/consts.php'))($container);
    (require_once(__DIR__ . '/bootstrap/persist/sql.php'))($container);
    (require_once(__DIR__ . '/bootstrap/persist/session.php'))($container);
    (require_once(__DIR__ . '/bootstrap/persist/filesystem.php'))($container);
    (require_once(__DIR__ . '/bootstrap/application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/utils.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/utils.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/views.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/router.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/server.php'))($container);    
    (require_once(__DIR__  . '/bootstrap/actions.php'))($container);
    
    /** 1st container get */
    (require_once(__DIR__  . '/bootstrap/http/actionsList.php'))($container);
    
    return $container;
};
