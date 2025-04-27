<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final class ArticleDto
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly bool $active
    ) {
    }
}
