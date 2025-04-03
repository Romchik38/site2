<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView;

use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;
use Romchik38\Site2\Application\Image\AdminView\CouldNotLoadImageMetadataException;

interface ImageMetadataLoaderInterface
{
    /** @throws CouldNotLoadImageMetadataException */
    public function loadMetadata(string $path): MetadataDto;
}