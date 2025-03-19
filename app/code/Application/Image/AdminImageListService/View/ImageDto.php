<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService\View;

use Romchik38\Site2\Domain\Author\VO\Name;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Path;

final class ImageDto
{
    public readonly Id $identifier;
    public readonly Name $authorName;
    public readonly Path $path;

    public function __construct(
        string $identifier,
        public readonly bool $active,
        string $authorName,
        string $path
    )
    {
        $this->identifier = new Id($identifier);
        $this->authorName = new Name($authorName);
        $this->path = new Path($path);
    }

    public function authorNameAsString(): string
    {
        return ($this->authorName)();
    }

    public function identifierAsString(): string
    {
        return ($this->identifier)();
    }

    public function pathAsString(): string
    {
        return ($this->path)();
    }
}