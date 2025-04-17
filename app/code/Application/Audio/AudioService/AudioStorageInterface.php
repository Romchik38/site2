<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AudioService;

use Romchik38\Site2\Domain\Audio\Entities\Content;
use Romchik38\Site2\Domain\Audio\VO\Path;

interface AudioStorageInterface
{
    /**
     * @throws CouldNotCreateContentException
     * @throws InvalidArgumentException
     * */
    public function createContent(mixed $file): Content;

    /**
     * @throws CouldNotDeleteAudioDataException
     */
    public function deleteByPath(Path $path): void;

    /**
     * @throws CouldNotLoadAudioDataException
     */
    public function load(Path $path): Content;

    /**
     * @throws CouldNotSaveAudioDataException
     */
    public function save(Content $content, Path $path): void;
}
