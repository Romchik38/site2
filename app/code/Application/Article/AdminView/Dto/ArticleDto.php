<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminView\Dto;

use DateTime;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Article\VO\Views;

final class ArticleDto
{
    public const DATE_FORMAT = 'd-m-Y G:i:s';
    /**
     * @param array<int,CategoryDto> $categories
     * @param array<int,TranslateDto> $translates
     */
    public function __construct(
        public readonly ArticleId $id,
        public readonly bool $active,
        public readonly DateTime $createdAt,
        public readonly DateTime $updatedAt,
        public readonly Views $views,
        public readonly ?AudioDto $audio,
        public readonly AuthorDto $author,
        public readonly ?ImageDto $image,
        public readonly array $categories,
        public readonly array $translates
    ) {
    }

    public function formatCreatedAt(): string
    {
        return $this->createdAt->format(self::DATE_FORMAT);
    }

    public function formatUpdatedAt(): string
    {
        return $this->updatedAt->format(self::DATE_FORMAT);
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getViews(): string
    {
        return (string) $this->views;
    }
}
