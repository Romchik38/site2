<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Image\VO\Id as ImageId;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;

final class ImageDto
{
    public function __construct(
        public readonly ImageId $id,
        public readonly bool $active,
        public readonly ImageName $name
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }
}
