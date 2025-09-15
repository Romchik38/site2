<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Audio\Entities;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final readonly class Article
{
    public function __construct(
        public ArticleId $id,
        public bool $active
    ) {
    }
}
