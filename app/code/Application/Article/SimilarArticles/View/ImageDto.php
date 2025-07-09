<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles\View;

use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;

final class ImageDto
{
    public function __construct(
        public readonly Id $id,
        public readonly Path $path,
        public readonly Description $description
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }

    public function getDescription(): string
    {
        return (string) $this->description;
    }
}
