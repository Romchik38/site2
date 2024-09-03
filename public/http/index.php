<?php

declare(strict_types=1);

require_once(__DIR__ . '/../../vendor/autoload.php');

$container = (require_once(__DIR__ . './../../app/bootstrap_http.php'))();

/** @var HttpServerInterface $server */
$server = $container->get(\Romchik38\Server\Api\Servers\Http\HttpServerInterface::class);

$server->run();

