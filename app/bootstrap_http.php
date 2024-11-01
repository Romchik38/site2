<?php

declare(strict_types=1);

use Romchik38\Container;

return function () {
    $container = new Container();
    
    $no_dependence = require_once(__DIR__ . '/bootstrap/no_dependence.php');
    $no_dependence($container);

    $http_no_dependence = require_once(__DIR__ . '/bootstrap/Http/no_dependence.php');
    $http_no_dependence($container);

    $sql_no_dependence = require_once(__DIR__ . '/bootstrap/Sql/no_dependencies.php');
    $sql_no_dependence($container);

    $sql_models = require_once(__DIR__ . '/bootstrap/Sql/models.php');
    $sql_models($container);

    $services = require_once(__DIR__ . '/bootstrap/services.php');
    $services($container);

    $models = require_once(__DIR__ . '/bootstrap/models.php');
    $models($container);
    
    $http_services = require_once(__DIR__ . '/bootstrap/Http/services.php');
    $http_services($container);

    $http_headers = require_once(__DIR__ . '/bootstrap/Http/headers.php');
    $http_headers($container);    

    $http_views = require_once(__DIR__ . '/bootstrap/Http/views.php');
    $http_views($container);

    $actions = require_once(__DIR__  . '/bootstrap/actions.php');
    $actions($container);

    $actionList = require_once(__DIR__  . '/bootstrap/Http/actionsList.php');
    $actionList($container);

    // ROUTER
    $router = require_once(__DIR__ . '/bootstrap/Http/router.php');
    $router($container);

    // SERVER
    $server = require_once(__DIR__ . '/bootstrap/Http/server.php');
    $server($container);

    return $container;
};
