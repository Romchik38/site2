<?php

declare(strict_types=1);

use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ImageCache\Cache;
use Romchik38\Site2\Application\ImageCache\ImageCacheService;
use Romchik38\Site2\Application\ImgConverter\ImgConverterService;
use Romchik38\Site2\Application\ImgConverter\ImgData;
use Romchik38\Site2\Application\ImgConverter\StubData;

require_once(__DIR__ . '/../../vendor/autoload.php');

try {
    $container = (require_once(__DIR__ . '/../../app/bootstrap_img.php'))();
    $request = $container->get(\Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface::class);
    /** @var ImgConverterService $imgConverterService */
    $imgConverterService = $container->get(Romchik38\Site2\Application\ImgConverter\ImgConverterService::class);
    /** @var ImageCacheService $imgCacheService */
    $imgCacheService = $container->get(\Romchik38\Site2\Application\ImageCache\ImageCacheService::class);
} catch (\Exception) {
    http_response_code(500);
    echo 'Server error, pleaser try again later';
    exit(1);
}

//  query example: id=1&type=webp&width=576&height=384

try {
    /** @var ServerRequestInterface $request */
    $data = $request->getQueryParams();
    $command = ImgData::fromRequest($data);
    $result = $imgConverterService->createImg($command);
    header(sprintf(
        'Content-Type: image/' . $result->type
    ));
    echo $result->data;
    // put data to cache
    $cache = new Cache(
        sprintf(
            'id:%s<>type:%s<>width:%s<>height:%s',
            $command->id,
            $command->type,
            $command->width,
            $command->height
        ),
        $result->data,
        $result->type
    );
    try{
        $imgCacheService->save($cache);
    } catch (\Exception) {
        // log 
    }
} catch (InvalidArgumentException) {
    http_response_code(400);
    echo 'Request parameters are invalid. Please check and try again';
} catch (NoSuchEntityException) {
    try {
        $commandStub = StubData::fromRequest($data, __DIR__ . '/404_1080_1080.webp');
        $result = $imgConverterService->createStub($commandStub);
        header(sprintf(
            'Content-Type: image/' . $result->type
        ));
        echo $result->data;
    } catch (\Exception) {
        http_response_code(500);
        echo 'Server error, pleaser try again later';
    }
} catch (\Exception) {
    http_response_code(500);
    echo 'Server error, pleaser try again later';
} finally {
    exit();
}
