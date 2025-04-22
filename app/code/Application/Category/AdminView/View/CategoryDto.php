<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminView\View;

use Romchik38\Site2\Domain\Category\VO\Identifier;

final class CategoryDto
{
    /**
     * @param array<int,ArticleDto> $articles
     * @param array<int,TranslateDto> $translates
     * */
    public function __construct(
        public readonly Identifier $id,
        public readonly array $articles,
        public readonly array $translates
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
