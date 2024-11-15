<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

/** Checks */
$bootstrapConfig = require_once(__DIR__ . '/../../app/config/shared/bootstrap.php');
/** 1. timezone */
$currentTimazone = ini_get('date.timezone');
$expectedTimezone = $bootstrapConfig['date.timezone'];
if ($expectedTimezone !== ini_get('date.timezone')) {
    echo (sprintf('check timezone, expected %s, current %s', $expectedTimezone, $currentTimazone));
    exit(1);
}
/** ? more checks */

/** init app */
$container = (require_once(__DIR__ . './../../app/bootstrap_http_sql.php'))();


/** run app */
$server = $container->get(\Romchik38\Server\Api\Servers\Http\HttpServerInterface::class);
$server->run()->log();
