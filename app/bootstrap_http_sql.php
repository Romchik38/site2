<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function () {
    $container = new Container();
    
    /** @todo refactor */
    $no_dependence = require_once(__DIR__ . '/bootstrap/no_dependence.php');
    $no_dependence($container);

    /** @todo refactor */
    $http_no_dependence = require_once(__DIR__ . '/bootstrap/http/no_dependence.php');
    $http_no_dependence($container);

    /** @todo refactor */
    $sql_models_no_dependence = require_once(__DIR__ . '/bootstrap/sql/no_dependencies.php');
    $sql_models_no_dependence($container);

    /** @todo refactor */
    $sql_models = require_once(__DIR__ . '/bootstrap/sql/models.php');
    $sql_models($container);

    /** @todo refactor */
    $critical_services = require_once(__DIR__ . '/bootstrap/critical_services.php');
    $critical_services($container);

    /** @todo refactor */
    $services_before_application = require_once(__DIR__ . '/bootstrap/services_before_application.php');
    $services_before_application($container);

    /** @todo refactor */
    $application = require_once(__DIR__ . '/bootstrap/application.php');
    $application($container); 

    /** @todo refactor */
    $services_after_application = require_once(__DIR__ . '/bootstrap/services_after_application.php');
    $services_after_application($container);

    /** @todo refactor */
    $services = require_once(__DIR__ . '/bootstrap/services.php');
    $services($container);

    /** @todo refactor */
    $http_services = require_once(__DIR__ . '/bootstrap/http/services.php');
    $http_services($container);

    /** @todo refactor */
    $http_views = require_once(__DIR__ . '/bootstrap/http/views.php');
    $http_views($container);

    /** @todo refactor */
    $actions = require_once(__DIR__  . '/bootstrap/actions.php');
    $actions($container);

    /** @todo refactor */
    $actionList = require_once(__DIR__  . '/bootstrap/http/actionsList.php');
    $actionList($container);

    /** @todo refactor */
    $router = require_once(__DIR__ . '/bootstrap/http/router.php');
    $router($container);

    /** @todo refactor */
    $server = require_once(__DIR__ . '/bootstrap/http/server.php');
    $server($container);

    return $container;
};
