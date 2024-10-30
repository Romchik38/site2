<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

final class Article implements ArticleInterface
{
    /** @param ArticleTranslatesInterface[] $translates */
    public function __construct(
        protected string $articleId,
        protected bool $active,
        protected readonly array $translates = [],
        protected readonly array $categories = []
    ) {}

    public function getId(): string
    {
        return $this->articleId;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getTranslate(string $language): ArticleTranslatesInterface|null
    {
        return $this->translates[$language] ?? null;
    }

    public function getCategory(string $categoryId): ArticleCategoryInterface|null
    {
        return $this->categories[$categoryId] ?? null;
    }

    public function getAllCategories(): array {
        return array_values($this->categories);
    }

    public function setId(string $id): ArticleInterface
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }

        $this->articleId = $id;
        return $this;
    }

    public function setActive(bool $active): ArticleInterface
    {
        $this->active = $active;
        return $this;
    }
}
