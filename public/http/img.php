<?php

declare(strict_types=1);

use Romchik38\Server\Services\Request\Http\ServerRequest;
use Romchik38\Server\Services\Request\Http\ServerRequestService;
use Romchik38\Server\Services\Request\Http\UriFactory;
use Romchik38\Site2\Infrastructure\Controllers\Img\ImgData;

require_once(__DIR__ . '/../../vendor/autoload.php');

$request = new ServerRequest(new UriFactory, new ServerRequestService);

$data = $request->getQueryParams();

$command = ImgData::fromRequest($data);

echo json_encode($command);



