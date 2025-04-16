<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {
    // IMG CONVERTER
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImgConverter\ImgConverter',
        '\Romchik38\Site2\Application\Image\ImgConverter\ImgConverterInterface'
    );

    // IMAGE METADATA LOADER
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\AdminView\ImageMetadataLoader',
        '\Romchik38\Site2\Application\Image\AdminView\ImageMetadataLoaderInterface'
    );

    // IMAGE CREATE CONTENT SERVICE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImageService\ImageStorageUseDiactoros',
        '\Romchik38\Site2\Application\Image\ImageService\CreateContentServiceInterface',
        true,
    );

    // IMAGE STORAGE 
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImageService\ImageStorageUseFile',
        '\Romchik38\Site2\Application\Image\ImageService\ImageStorageInterface',
        true,
        [
            new Promise('img-folder-backend'),
        ]
    );

    return $container;
};
