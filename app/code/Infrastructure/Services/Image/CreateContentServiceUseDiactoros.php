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

final class CreateContentServiceUseDiactoros implements CreateContentServiceInterface
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

        $dimensions = getimagesizefromstring($data);
        if ($dimensions === false) {
            throw new CouldNotCreateContentException('Can\'t determine demensions, image data is not valid');
        }
        
        try {
            $imageMetadata = new Image($dimensions);
        } catch (InvalidArgumentException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        }

        $image = imagecreatefromstring($data);
        if ($image === false || gettype($image) === 'resource') {
            throw new CouldNotCreateContentException('Image creation aborted: type not GdImage');
        }

        $content = new Content(
            $image,
            new Type($imageMetadata->originalType),
            new Height($imageMetadata->originalHeight),
            new Width($imageMetadata->originalWidth),
            new Size($file->getSize())
        );
        return $content;
    }
}
