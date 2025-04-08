<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use Romchik38\Site2\Application\Image\ImageService\CouldNotDeleteImageDataException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotLoadImageDataException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotSaveImageDataException;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Path;

interface ImageStorageInterface
{
    /**
     * @throws CouldNotLoadImageDataException
     */
    public function load(Path $path): Content;

    /**
     * @throws CouldNotSaveImageDataException
     */
    public function save(Content $content, Path $path): void;

    /**
     * @throws CouldNotDeleteImageDataException
     */
    public function delete(Path $path): void;
}
