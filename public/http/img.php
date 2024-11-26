<?php

declare(strict_types=1);

use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;
use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\ImageCache\Cache;
use Romchik38\Site2\Application\ImageCache\ImageCacheService;
use Romchik38\Site2\Application\ImageCacheView\Find;
use Romchik38\Site2\Application\ImageCacheView\ImageCacheViewService;
use Romchik38\Site2\Application\ImageCacheView\NoSuchImageCacheException;
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
    /** @var ImageCacheViewService $imgCacheViewService */
    $imgCacheViewService = $container->get(\Romchik38\Site2\Application\ImageCacheView\ImageCacheViewService::class);
} catch (\Exception $e) {
    http_response_code(500);
    echo 'Server error, pleaser try again later';
    exit(1);
}

//  query example: id=1&type=webp&width=576&height=384


// Same data
/** @var ServerRequestInterface $request */
$data = $request->getQueryParams();
$command = ImgData::fromRequest($data);
$keyTemplate = 'id:%s<>type:%s<>width:%s<>height:%s';

// Case 1 - from cache
try {
    $key = sprintf(
        $keyTemplate,
        $command->id,
        $command->type,
        $command->width,
        $command->height
    );

    $result = $imgCacheViewService->getByKey(new Find($key));
    header(sprintf(
        'Content-Type: image/' . $result->type()
    ));
    echo base64_decode($result->data());
    exit(0);
} catch (NoSuchImageCacheException) {
    // create new image (see Case 2 below)
} catch (\Exception $e) {
    // do error log
}

// Case 2 - no cache
try {
    $result = $imgConverterService->createImg($command);
    header(sprintf(
        'Content-Type: image/' . $result->type
    ));
    echo $result->data;
    // put data to cache
    $cache = new Cache(
        sprintf(
            $keyTemplate,
            $command->id,
            $command->type,
            $command->width,
            $command->height
        ),
        base64_encode($result->data),
        $result->type
    );
    try {
        $imgCacheService->save($cache);
    } catch (\Exception $e) {
        // do log because image was not cached
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
