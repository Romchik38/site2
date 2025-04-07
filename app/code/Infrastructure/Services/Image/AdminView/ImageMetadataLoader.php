<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image\AdminView;

use InvalidArgumentException;
use Romchik38\Site2\Application\Image\AdminView\CouldNotLoadImageMetadataException;
use Romchik38\Site2\Application\Image\AdminView\ImageMetadataLoaderInterface;
use Romchik38\Site2\Application\Image\AdminView\View\MetadataDto;
use Romchik38\Site2\Infrastructure\Services\Image\AbstractImageStorageUseGd;
use RuntimeException;

use function filesize;
use function sprintf;

final class ImageMetadataLoader extends AbstractImageStorageUseGd implements ImageMetadataLoaderInterface
{   
    public function createMetadataDto(string $path): MetadataDto
    {
        try {
            $image = $this->loadMetaDataFromFile($path);
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
            $image->width,
            $image->height,
            $image->type,
            $bytes
        );
    }
}
