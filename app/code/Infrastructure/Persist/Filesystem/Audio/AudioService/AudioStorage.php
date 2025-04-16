<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio\AudioService;

use Romchik38\Site2\Application\Audio\AudioService\AudioStorageInterface;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotDeleteAudioDataException;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotLoadAudioDataException;
use Romchik38\Site2\Application\Audio\AudioService\CouldNotSaveAudioDataException;
use Romchik38\Site2\Domain\Audio\Entities\Content;
use Romchik38\Site2\Domain\Audio\VO\Path;
use Romchik38\Site2\Domain\Audio\VO\Size;
use Romchik38\Site2\Domain\Audio\VO\Type;
use Romchik38\Site2\Infrastructure\Persist\Filesystem\Audio\AbstractAudioStorage;
use RuntimeException;

final class AudioStorage extends AbstractAudioStorage implements AudioStorageInterface
{
    public function __construct(
        private readonly string $pathPrefix
    ) {
    }

    /**
     * @throws CouldNotLoadAudioDataException
     */
    public function load(Path $path): Content
    {
        $fullPath = $this->pathPrefix . $path();
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
    }

    /**
     * @todo implement
     * @throws CouldNotDeleteAudioDataException
     */
    public function deleteByPath(Path $path): void
    {
    }
}
