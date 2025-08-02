<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article\View;

use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;

final class ImageDto
{
    public function __construct(
        public readonly Id $id,
        public readonly Description $description,
        public readonly Path $path
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }
}
