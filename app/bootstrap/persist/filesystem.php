<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    // AUDIOSERVICE STORAGE
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio\AudioService\AudioStorageUseDiactoros',
        '\Romchik38\Site2\Application\Audio\AudioService\AudioStorageInterface',
        true,
        [
            new Promise('audio-folder-backend')
        ]
    );

    // IMG CONVERTER
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Filesystem\Image\ImgConverter\ImageStorage',
        '\Romchik38\Site2\Application\Image\ImgConverter\ImageStorageInterface',
        true,
        [
            new Promise('img-folder-backend'),
        ]
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
