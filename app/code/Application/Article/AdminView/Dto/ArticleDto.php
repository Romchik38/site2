<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final class ArticleDto
{
    /**
     * @param array<int,Translate> $translates
     * @param array<int,ArticleId> $articles
     */
    public function __construct(
        public readonly ArticleId $id,
        public readonly bool $active,
        public readonly ?Image $image,
        public readonly array $translates
    ) {
    }
}
