<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Image\VO\Id as ImageId;

final readonly class ImageDto
{
    public function __construct(
        public ImageId $id
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
