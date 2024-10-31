<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Article;

use Romchik38\Site2\Api\Models\DTO\Article\ArticleDTOInterface;

final class ArticleDTO implements ArticleDTOInterface
{
    protected const DATE_FORMAT_CATEGORY_PAGE = 'j-n-y';

    public function __construct(
        protected string $articleId,
        protected bool $active,
        protected string $name,
        protected string $shortDescription,
        protected string $description,
        protected \DateTime $createdAt,
        protected \DateTime $updatedAt,
        protected array $categories
    ) {}
        
    public function getId(): string
    {
        return $this->articleId;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    /** additional functionality */
    public function getFormattedCreatedAt(): string {
        return $this->createdAt->format($this::DATE_FORMAT_CATEGORY_PAGE);
    }
}
