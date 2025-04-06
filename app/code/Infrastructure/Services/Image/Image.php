<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Image\VO\Type;
use RuntimeException;

use function explode;
use function file_exists;
use function getimagesize;
use function in_array;
use function is_readable;
use function sprintf;

class Image
{
    /**
     * Types to convert.
     * The loaded from storage image must be in array to be converted
     * */
    //protected const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public readonly int $originalWidth;
    public readonly int $originalHeight;
    public readonly string $originalType;

    /**
     * @param array<int|string,mixed> $dimensions
     * @throws InvalidArgumentException 
     * */
    public function __construct(
        array $dimensions
    ) {
        $originalWidth = $dimensions[0];
        if ($originalWidth === 0) {
            throw new InvalidArgumentException('Cannot determine image width size');
        }
        $this->originalWidth  = $originalWidth;
        $this->originalHeight = $dimensions[1];

        $mime = $dimensions['mime'] ?? null;
        if ($mime === null) {
            throw new InvalidArgumentException('Cannot determine image width size');
        }
        $this->originalType = (explode('/', $mime))[1];
    }

    // /**
    //  * @throws InvalidArgumentException
    //  */
    // public static function fromFilePath(string $filePath): self
    // {
    //     if (! file_exists($filePath) || (! is_readable($filePath))) {
    //         throw new InvalidArgumentException(sprintf(
    //             'Image file %s not exist',
    //             $filePath
    //         ));
    //     }

    //     $dimensions = getimagesize($filePath);
    //     if ($dimensions === false) {
    //         throw new InvalidArgumentException('Can\'t determine demensions, image is not valid');
    //     }
    //     return new self($dimensions);
    // }
}
