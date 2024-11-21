<?php

declare(strict_types=1);

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Server\Services\Request\Http\ServerRequest;
use Romchik38\Server\Services\Request\Http\ServerRequestService;
use Romchik38\Server\Services\Request\Http\UriFactory;
use Romchik38\Site2\Application\ImgConverter\ImgConverterService;
use Romchik38\Site2\Infrastructure\Controllers\Img\ImgData;

require_once(__DIR__ . '/../../vendor/autoload.php');

$request = new ServerRequest(new UriFactory, new ServerRequestService);

$data = $request->getQueryParams();

$command = ImgData::fromRequest($data);

$imgConverterService = new ImgConverterService(
    
);

//       /img.php?id=126&type=webp&aspect_ratio=1&size=576

try {
    $imgConverterService->createImg($command);
    echo 'ok';
} catch (InvalidArgumentException) {
    http_response_code(400);
    echo 'Request parameters are invalid. Please check and try again';
} catch (NoSuchEntityException) {
    http_response_code(404);
    echo 'Requested img not found';
} catch (\Exception) {
    http_response_code(500);
    echo 'Server error, pleaser try again later';
}
