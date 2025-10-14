<?php

declare(strict_types=1);

use Romchik38\Container\Container;

require_once(__DIR__ . '/../../vendor/autoload.php');

// memory usage #1 before container
$m1 = memory_get_usage(true)/1_000_000;

/** init app */
$container = (require_once(__DIR__ . './../../app/bootstrap_http_sql.php'))(new Container);

// memory usage #2 after container
$m2 = memory_get_usage(true)/1_000_000;

/** Checks */
/** 1. timezone */
$currentTimazone = ini_get('date.timezone');
$expectedTimezone = $container->get('date.timezone');
if ($expectedTimezone !== ini_get('date.timezone')) {
    ini_set('date.timezone', $expectedTimezone);
}

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

/** 
 * run app 
 * @var \Romchik38\Server\Http\Servers\HttpServerInterface $server
 * */
$server = $container->get('\Romchik38\Server\Http\Servers\HttpServerInterface');

// memory usage #3 server initialized
$m3 = memory_get_usage(true)/1_000_000;

$server->handle($request);

// memory usage #5 response sent
$m5 = memory_get_usage(true)/1_000_000;

$logger = $container->get('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface');
$logger->sendAllLogs();
$accessLogger = $container->get('access_logger');
$accessLogger->sendAllLogs();