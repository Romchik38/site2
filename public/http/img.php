<?php

declare(strict_types=1);

use Romchik38\Server\Api\Services\Request\Http\ServerRequestInterface;
use Romchik38\Server\Models\Errors\NoSuchEntityException;
use Romchik38\Site2\Application\Image\ImgConverter\CouldNotCreateImageException;
use Romchik38\Site2\Application\Image\ImgConverter\ImgConverterService;
use Romchik38\Site2\Application\Image\ImgConverter\ImgData;
use Romchik38\Site2\Application\Image\ImgConverter\StubData;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService;
use Romchik38\Site2\Application\ImageCache\View\Commands\Find\Find;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\NoSuchImageCacheException;
use Romchik38\Site2\Application\ImageCache\View\Exceptions\RepositoryException as CacheRepositoryException;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Cache;
use Romchik38\Site2\Application\ImageCache\ImageCacheService\Exceptions\CouldNotSaveException;
use Romchik38\Server\Api\Services\LoggerServerInterface;

require_once(__DIR__ . '/../../vendor/autoload.php');

try {
    $container = (require_once(__DIR__ . '/../../app/bootstrap_img.php'))();
    $request = $container->get('\Psr\Http\Message\ServerRequestInterface');
    /** @var ImgConverterService $imgConverterService */
    $imgConverterService = $container->get('\Romchik38\Site2\Application\Image\ImgConverter\ImgConverterService');
    /** @var ImageCacheService $imgCacheService */
    $imgCacheService = $container->get('\Romchik38\Site2\Application\ImageCache\ImageCacheService\ImageCacheService');
    /** @var ViewService $imgCacheViewService */
    $imgCacheViewService = $container->get('\Romchik38\Site2\Application\ImageCache\View\ViewService');
    /** @var LoggerServerInterface $logger */
    $logger = $container->get('\Romchik38\Server\Api\Services\LoggerServerInterface');
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
} catch (CacheRepositoryException $e) {
    $logger->error($e->getMessage());
    $logger->sendAllLogs();
    exit('We are sorry, there is an error on our side, please try later');
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
    } catch (CouldNotSaveException $e) {
        $logger->error($e->getMessage());
    } catch (InvalidArgumentException $e) {
        $logger->error($e->getMessage());
    }
} catch (InvalidArgumentException) {
    http_response_code(400);
    echo 'Request parameters are invalid. Please check and try again';
} catch (NoSuchEntityException) {
    try {
        $commandStub = StubData::fromRequest($data, 'common/404_1080_1080.webp');
        $result = $imgConverterService->createStub($commandStub);
        header(sprintf(
            'Content-Type: image/' . $result->type
        ));
        echo $result->data;
    } catch (\Exception) {
        http_response_code(500);
        echo 'Server error, pleaser try again later';
    }
} catch(CouldNotCreateImageException $e){
    http_response_code(500);
    $logger->error($e->getMessage());
    echo 'Server error, please try again later';
} catch (\Exception) {
    http_response_code(500);
    echo 'Server error, please try again later';
} finally {
    $logger->sendAllLogs();
    exit();
}
