<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    
    // Order does not matter till 1st container get
    (require_once(__DIR__ . '/bootstrap/no_dependence.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/no_dependence.php'))($container);
    (require_once(__DIR__ . '/bootstrap/sql/no_dependencies.php'))($container);    
    (require_once(__DIR__ . '/bootstrap/sql/models.php'))($container);
    (require_once(__DIR__ . '/bootstrap/critical_services.php'))($container);
    (require_once(__DIR__ . '/bootstrap/services_before_application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/services_after_application.php'))($container);
    (require_once(__DIR__ . '/bootstrap/services.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/views.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/server.php'))($container);
    (require_once(__DIR__ . '/bootstrap/http/router.php'))($container);


    /** 1st container get */
    (require_once(__DIR__  . '/bootstrap/actions.php'))($container);
    (require_once(__DIR__  . '/bootstrap/http/actionsList.php'))($container);
    



    return $container;
};
