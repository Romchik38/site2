<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\Entities\Category;
use Romchik38\Site2\Domain\Article\Entities\Translates;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;

use function array_values;
use function sprintf;

final class Article
{
    /**
     * @param array<string|int,Translates> $translates
     * @param array<string|int,Category> $categories
     */
    public function __construct(
        protected ArticleId $articleId,
        protected bool $active,
        protected readonly array $translates = [],
        protected readonly array $categories = []
    ) {
    }

    public function getId(): ArticleId
    {
        return $this->articleId;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    /** @throws InvalidArgumentException - When translate is missing. */
    public function getTranslate(string $language): Translates
    {
        $translate = $this->translates[$language] ?? null;
        if ($translate === null) {
            throw new InvalidArgumentException(
                sprintf(
                    'Translate %s for Article id %s is missing',
                    $language,
                    ($this->articleId)(),
                )
            );
        }

        return $translate;
    }

    /** @return Translates[] */
    public function getAllTranslates(): array
    {
        return array_values($this->translates);
    }

    public function getCategory(string $categoryId): ?Category
    {
        return $this->categories[$categoryId] ?? null;
    }

    /** @return Category[] */
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
