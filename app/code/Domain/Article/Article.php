<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class Article
{
    public function __construct(
        protected ArticleId $articleId,
        protected bool $active,
        protected readonly array $translates = [],
        protected readonly array $categories = []
    ) {}

    public function getId(): ArticleId
    {
        return $this->articleId;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getTranslate(string $language): ArticleTranslates|null
    {
        return $this->translates[$language] ?? null;
    }

    public function getCategory(string $categoryId): ArticleCategory|null
    {
        return $this->categories[$categoryId] ?? null;
    }

    /** @return ArticleCategory[] */
    public function getAllCategories(): array
    {
        return array_values($this->categories);
    }

    public function setId(ArticleId $id): self
    {
        $this->articleId = $id;
        return $this;
    }

    public function activate(): self
    {
        $this->active = true;
        return $this;
    }

    public function dectivate(): self
    {
        $this->active = false;
        return $this;
    }
}
