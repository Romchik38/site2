<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Domain\Image\VO\Path;
use Romchik38\Site2\Application\Image\ImageService\CouldNotSaveImageDataException;
use Romchik38\Site2\Application\Image\ImageService\CouldNotLoadImageDataException;
use Romchik38\Site2\Domain\Image\VO\Type;

interface ImageStorageInterface
{
    /**
     * @throws CouldNotLoadImageDataException
    */
    public function load(Path $path, Type $type): Content;
    
    /**
     * @throws CouldNotSaveImageDataException
     */
    public function save(Content $content, Path $path): void;
}
