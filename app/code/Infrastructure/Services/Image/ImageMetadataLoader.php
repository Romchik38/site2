<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use InvalidArgumentException;
use Romchik38\Site2\Application\Image\AdminView\CouldNotLoadImageMetadataException;
use Romchik38\Site2\Application\Image\AdminView\ImageMetadataLoaderInterface;
use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;
use RuntimeException;

use function filesize;
use function sprintf;

final class ImageMetadataLoader implements ImageMetadataLoaderInterface
{
    use DimensionsTraits;
    
    public function loadMetadataFromFile(string $path): MetadataDto
    {
        try {
            $demensions = $this->fromFilePath($path);
            $image = new Image($demensions);
        } catch (InvalidArgumentException $e) {
            throw new CouldNotLoadImageMetadataException($e->getMessage());
        } catch (RuntimeException $e) {
            throw new CouldNotLoadImageMetadataException($e->getMessage());
        }

        $bytes = filesize($path);
        if ($bytes === false) {
            throw new CouldNotLoadImageMetadataException(sprintf(
                'Could not read file size %s',
                $path
            ));
        }

        return new MetadataDto(
            $image->originalWidth,
            $image->originalHeight,
            $image->originalType,
            $bytes
        );
    }
}
