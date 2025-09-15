<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\AdminView\View;

use Romchik38\Site2\Domain\Category\VO\Identifier;

final readonly class CategoryDto
{
    /**
     * @param array<int,ArticleDto> $articles
     * @param array<int,TranslateDto> $translates
     * */
    public function __construct(
        public Identifier $id,
        public bool $active,
        public array $articles,
        public array $translates
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
