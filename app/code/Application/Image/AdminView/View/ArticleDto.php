<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final readonly class ArticleDto
{
    public function __construct(
        public ArticleId $id,
        public bool $active
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
