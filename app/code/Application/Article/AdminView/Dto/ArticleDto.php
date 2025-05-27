<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

final class ArticleDto
{
    /**
     * @param array<int,CategoryDto> $categories
     * @param array<int,TranslateDto> $translates
     */
    public function __construct(
        public readonly ArticleId $id,
        public readonly bool $active,
        public readonly ?AudioDto $audio,
        public readonly AuthorDto $author,
        public readonly ?ImageDto $image,
        public readonly array $categories,
        public readonly array $translates
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }
}
