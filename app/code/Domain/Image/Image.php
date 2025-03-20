<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Image;

use Romchik38\Site2\Domain\Author\VO\AuthorId;
use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name;

final class Image
{
    protected bool $isLoaded = false;
    protected string $data;

    public function __construct(
        protected readonly Id $id,
        protected readonly Name $name,
        protected readonly AuthorId $authorId,
        protected readonly Description $description
    ) {
    }

    public function load(string $data): void
    {
        $this->data     = $data;
        $this->isLoaded = true;
    }

    public function isLoaded(): bool
    {
        return $this->isLoaded;
    }
}
