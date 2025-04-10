<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class Article
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly bool $active
    ) {
    }
}
