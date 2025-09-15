<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService\View;

use Romchik38\Site2\Domain\Author\VO\Name as AuthorName;
use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path;

final readonly class ImageDto
{
    public function __construct(
        public ImageId $identifier,
        public bool $active,
        public ImageName $name,
        public AuthorName $authorName,
        public Path $path
    ) {
    }

    public function getId(): string
    {
        return (string) $this->identifier;
    }

    public function getImageName(): string
    {
        return (string) $this->name;
    }

    public function getAuthorName(): string
    {
        return (string) $this->authorName;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'image_id'          => ($this->identifier)(),
            'image_active'      => $this->active,
            'image_name'        => ($this->name)(),
            'image_author_name' => ($this->authorName)(),
            'image_path'        => ($this->path)(),
        ];
    }
}
