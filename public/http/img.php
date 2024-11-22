<?php

declare(strict_types=1);

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Infrastructure\Controllers\Img\ImgData;

require_once(__DIR__ . '/../../vendor/autoload.php');

try {
    $container = (require_once(__DIR__ . '/../../app/bootstrap_img.php'))();
    $request = $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class);
    $imgConverterService = $container->get(Romchik38\Site2\Application\ImgConverter\ImgConverterService::class);

    $data = $request->getQueryParams();
    $command = ImgData::fromRequest($data);
}  catch(\Exception){
    http_response_code(500);
    echo 'Server error, pleaser try again later';
    exit(1);
}

//       /img.php?id=1&type=webp&aspect_ratio=1&size=576

try {
    $result = $imgConverterService->createImg($command);
    header(sprintf(
        'Content-Type: image/webp'
    ));
    echo $result;
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
