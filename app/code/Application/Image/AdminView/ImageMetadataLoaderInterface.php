<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Application\Image\AdminView\CouldNotLoadImageMetadataException;
use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;

interface ImageMetadataLoaderInterface
{
    /** @throws CouldNotLoadImageMetadataException */
    public function createMetadataDto(string $path): MetadataDto;
}
