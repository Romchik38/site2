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
$server->handle($request);

$logger = $container->get('\Romchik38\Server\Utils\Logger\DeferredLogger\DeferredLoggerInterface');
$logger->sendAllLogs();