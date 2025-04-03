<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use Romchik38\Site2\Application\Image\AdminView\CouldNotLoadImageMetadataException;
use Romchik38\Site2\Application\Image\AdminView\ImageMetadataLoaderInterface;
use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;
use RuntimeException;

final class ImageMetadataLoader implements ImageMetadataLoaderInterface
{
    public function loadMetadata(string $path): MetadataDto
    {
        try {
            $image = new Image($path);
        } catch (RuntimeException $e) {
            throw new CouldNotLoadImageMetadataException($e->getMessage());
        }

        

        return new MetadataDto();
    }
}