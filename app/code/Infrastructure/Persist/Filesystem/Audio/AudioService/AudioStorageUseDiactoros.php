<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio\AudioService;

use Laminas\Diactoros\Exception\UploadedFileAlreadyMovedException;
use Laminas\Diactoros\Exception\UploadedFileErrorException;
use Laminas\Diactoros\UploadedFile;
use Romchik38\Site2\Application\Audio\AudioService\AudioStorageInterface;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotCreateContentException;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotDeleteAudioDataException;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotLoadAudioDataException;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotSaveAudioDataException;
use Romchik38\Site2\Domain\Audio\Entities\Content;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;
use Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio\AbstractAudioStorage;
use RuntimeException;

use function gettype;
use function sprintf;

final class AudioStorageUseDiactoros extends AbstractAudioStorage implements AudioStorageInterface
{
    public function __construct(
        private readonly string $pathPrefix
    ) {
    }

    /**
     * @throws CouldNotCreateContentException
     * @throws InvalidArgumentException
     * */
    public function createContent(mixed $file): Content
    {
        if (! $file instanceof UploadedFile) {
            $type = gettype($file);
            if ($type === 'object') {
                $type = $file::class;
            }
            throw new CouldNotCreateContentException(sprintf(
                'Param file is invalid: expected \Laminas\Diactoros\UploadedFile, given %s',
                $type
            ));
        }

        try {
            $stream     = $file->getStream();
            $data       = $stream->getContents();
            $properties = $this->getPropertiesFromString($data);
        } catch (RuntimeException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        } catch (UploadedFileAlreadyMovedException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        } catch (UploadedFileErrorException $e) {
            throw new CouldNotCreateContentException($e->getMessage());
        }

        return new Content(
            $data,
            new Type($properties->type),
            new Size($properties->size)
        );
    }

    /**
     * @throws CouldNotLoadAudioDataException
     */
    public function load(Path $path): Content
    {
        $fullPath = $this->createFullPath($path);
        try {
            $data       = $this->loadAudioFromFile($fullPath);
            $properties = $this->getPropertiesFromString($data);
            return new Content(
                $data,
                new Type($properties->type),
                new Size($properties->size)
            );
        } catch (RuntimeException $e) {
            throw new CouldNotLoadAudioDataException($e->getMessage());
        }
    }

    /**
     * @todo implement
     * @throws CouldNotSaveAudioDataException
     */
    public function save(Content $content, Path $path): void
    {
        $fullPath = $this->createFullPath($path);
        try {
            $this->saveAudioToFile($content->getData(), $fullPath);
        } catch (RuntimeException $e) {
            throw new CouldNotSaveAudioDataException($e->getMessage());
        }
    }

    /**
     * @todo implement
     * @throws CouldNotDeleteAudioDataException
     */
    public function deleteByPath(Path $path): void
    {
        $fullPath = $this->createFullPath($path);
        try {
            $this->deleteAudioFile($fullPath);
        } catch (RuntimeException $e) {
            throw new CouldNotDeleteAudioDataException($e->getMessage());
        }
    }

    private function createFullPath(Path $path): string
    {
        return sprintf(
            '%s/%s',
            $this->pathPrefix,
            $path()
        );
    }
}
