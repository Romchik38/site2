<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Services\Image;

use GdImage;
use InvalidArgumentException;
use Romchik38\Site2\Application\Image\ImageService\CreateContentServiceInterface;
use Romchik38\Site2\Domain\Image\Entities\Content;
use Romchik38\Site2\Application\Image\ImageService\CouldNotCreateContentException;
use Romchik38\Site2\Domain\Image\VO\Height;
use Romchik38\Site2\Domain\Image\VO\Size;
use Romchik38\Site2\Domain\Image\VO\Type;
use Romchik38\Site2\Domain\Image\VO\Width;
use RuntimeException;

final class CreateContentServiceUseDiactoros extends AbstractImageStorageUseGd 
    implements CreateContentServiceInterface
{
    public function createContent(mixed $file): Content
    {
        /** @todo test */
        if (! $file instanceof \Laminas\Diactoros\UploadedFile) {
            $type = gettype($file);
            if ($type === 'object') {
                $type = get_class($file);
            }
            throw new CouldNotCreateContentException(sprintf(
                'Param file is invalid: expected \Laminas\Diactoros\UploadedFile, given %s',
                $type
            ));
        }

        $stream = $file->getStream();
        $data = $stream->getContents();

        try {
            $imageMetadata = $this->loadMetaDataFromString($data);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        }

        $image = imagecreatefromstring($data);
        if ($image === false || gettype($image) === 'resource') {
            throw new CouldNotCreateContentException('Image creation aborted: type not GdImage');
        }

        $content = new Content(
            $image,
            new Type($imageMetadata->type),
            new Height($imageMetadata->height),
            new Width($imageMetadata->width),
            new Size($file->getSize())
        );
        return $content;
    }
}
