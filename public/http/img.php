<?php

declare(strict_types=1);

use Romchik38\Server\Services\Request\Http\Request;
use Romchik38\Server\Services\Request\Http\UriFactory;

require_once(__DIR__ . '/../../vendor/autoload.php');

$request = new Request(new UriFactory);
$uri = $request->getUri();
$scheme = $uri->getScheme();
$host = $uri->getHost();
$path = urlencode($uri->getPath());
$controllerName = '/img';
$location = sprintf(
    '%s://%s%s?url=%s',
    $scheme,
    $host,
    $controllerName,
    $path
);

header(sprintf('Location: %s', $location));
