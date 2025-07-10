<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\View;

use Romchik38\Site2\Domain\Image\VO\Description;
use Romchik38\Site2\Domain\Image\VO\Id;

final class ImageDto
{
    public function __construct(
        public readonly Id $id,
        public readonly Description $description
    ) {
    }
}
