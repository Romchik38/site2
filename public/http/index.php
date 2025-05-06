<?php

declare(strict_types=1);

use Romchik38\Container\Container;

require_once(__DIR__ . '/../../vendor/autoload.php');

/** init app */
$container = (require_once(__DIR__ . './../../app/bootstrap_http_sql.php'))(new Container);

/** Checks */
/** 1. timezone */
$currentTimazone = ini_get('date.timezone');
$expectedTimezone = $container->get('date.timezone');
if ($expectedTimezone !== ini_get('date.timezone')) {
    echo (sprintf('check timezone, expected %s, current %s', $expectedTimezone, $currentTimazone));
    exit(1);
}

/** run app */
$server = $container->get('\Romchik38\Server\Http\Servers\HttpServerInterface');
$server->run();

/** @todo do log with deffered logger */
// logger->sendAllLogs()
