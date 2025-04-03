<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    
    // Order does not matter till 1st container get
    (require_once(__DIR__ . '/bootstrap/consts.php'))($container);
    (require_once(__DIR__ . '/bootstrap/models.php'))($container);
    (require_once(__DIR__ . '/bootstrap/sql/models.php'))($container);
    (require_once(__DIR__ . '/bootstrap/application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/services.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/views.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/server.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/router.php'))($container);
    (require_once(__DIR__  . '/bootstrap/actions.php'))($container);
    
    /** 1st container get */
    (require_once(__DIR__  . '/bootstrap/http/actionsList.php'))($container);
    
    return $container;
};
