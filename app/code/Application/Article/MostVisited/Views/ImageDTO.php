<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\MostVisited\Views;

use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id;

final readonly class ImageDTO
{
    public function __construct(
        public Id $id,
        public Description $description
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
}
