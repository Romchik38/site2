<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class ArticleDto
{
    public function __construct(
        public readonly ArticleId $id,
        public readonly bool $active
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
