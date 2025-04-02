<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Image\VO\Id;
use Romchik38\Site2\Domain\Image\VO\Name as ImageName;
use Romchik38\Site2\Domain\Image\VO\Path;

final class Dto
{
    public function __construct(
        public readonly Id $identifier,
        public readonly bool $active,
        public readonly ImageName $name,
        public readonly Path $path,
        public readonly AuthorDto $author
    ) {
    }
}
