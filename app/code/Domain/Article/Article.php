<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

final class Article
{
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

    /** @throws InvalidArgumentException when string is empty */    
    public function setId(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }

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
