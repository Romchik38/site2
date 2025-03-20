<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService\View;

use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path;

final class ImageDto
{
    public readonly Id $identifier;
    public readonly ImageName $name;
    public readonly AuthorName $authorName;
    public readonly Path $path;

    public function __construct(
        string $identifier,
        public readonly bool $active,
        string $name,
        string $authorName,
        string $path
    ) {
        $this->identifier = new Id($identifier);
        $this->name       = new ImageName($name);
        $this->authorName = new AuthorName($authorName);
        $this->path       = new Path($path);
    }
}
