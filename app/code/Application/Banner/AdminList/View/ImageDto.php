<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Banner\AdminList\View;

use Romchik38\Site2\Domain\Image\VO\Id;

final readonly class ImageDto
{
    public function __construct(
        public Id $id,
        public bool $active
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
