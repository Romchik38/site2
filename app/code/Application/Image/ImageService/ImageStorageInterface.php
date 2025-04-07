<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Path;

interface ImageStorageInterface
{
    /**
     * @throws CouldNotSaveImageDataException
     */
    public function save(Content $content, Path $path): void;
}
