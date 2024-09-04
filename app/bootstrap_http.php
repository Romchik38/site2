<?php

declare(strict_types=1);

use Romchik38\Container;

return function () {
    $container = new Container();
    
    $no_dependence = require_once(__DIR__ . '/bootstrap/no_dependence.php');
    $no_dependence($container);

    $http_no_dependence = require_once(__DIR__ . '/bootstrap/Http/no_dependence.php');
    $http_no_dependence($container);

    $services = require_once(__DIR__ . '/bootstrap/services.php');
    $services($container);

    $http_services = require_once(__DIR__ . '/bootstrap/Http/services.php');
    $http_services($container);

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
