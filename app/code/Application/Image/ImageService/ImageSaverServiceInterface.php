<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\ImageService;

use GdImage;
use Romchik38\Site2\Domain\Image\VO\Type;

interface ImageSaverServiceInterface
{
    /**
     * @throws CouldNotSaveImageDataException
     */
    public function saveImageToFile(
        GdImage $data,
        string $fullPath,
        Type $type
    ): void;
}
