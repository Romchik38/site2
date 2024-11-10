<?php

declare(strict_types=1);

use Romchik38\Container;

return function () {
    $container = new Container();
    
    $no_dependence = require_once(__DIR__ . '/bootstrap/no_dependence.php');
    $no_dependence($container);

    $http_no_dependence = require_once(__DIR__ . '/bootstrap/http/no_dependence.php');
    $http_no_dependence($container);

    $before_models = require_once(__DIR__ . '/bootstrap/sql/before_models.php');
    $before_models($container);

    $sql_models = require_once(__DIR__ . '/bootstrap/sql/models.php');
    $sql_models($container);

    $sql_models = require_once(__DIR__ . '/bootstrap/sql/models.php');
    $sql_models($container);

    $application = require_once(__DIR__ . '/bootstrap/application.php');
    $application($container); 

    $services_after_application = require_once(__DIR__ . '/bootstrap/services_after_application.php');
    $services_after_application($container);

    $services = require_once(__DIR__ . '/bootstrap/services.php');
    $services($container);

    $http_services = require_once(__DIR__ . '/bootstrap/http/services.php');
    $http_services($container);

    $http_headers = require_once(__DIR__ . '/bootstrap/http/headers.php');
    $http_headers($container);    

    $http_views = require_once(__DIR__ . '/bootstrap/http/views.php');
    $http_views($container);

    $actions = require_once(__DIR__  . '/bootstrap/actions.php');
    $actions($container);

    $actionList = require_once(__DIR__  . '/bootstrap/http/actionsList.php');
    $actionList($container);

    // ROUTER
    $router = require_once(__DIR__ . '/bootstrap/http/router.php');
    $router($container);

    // SERVER
    $server = require_once(__DIR__ . '/bootstrap/http/server.php');
    $server($container);

    return $container;
};
