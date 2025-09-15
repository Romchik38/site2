<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Author\AdminView\View;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final readonly class ArticleDto
{
    public function __construct(
        public ArticleId $id
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
