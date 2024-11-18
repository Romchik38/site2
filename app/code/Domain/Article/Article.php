<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use Romchik38\Server\Models\Errors\EntityLogicException;
use Romchik38\Site2\Domain\Article\VO\ArticleId;

final class Article
{
    /** 
     * @param array<string|int,ArticleTranslates> $translates
     * @param array<string|int,ArticleCategory> $categories
     */
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

    /** @throws EntityLogicException When translate is missing */
    public function getTranslate(string $language): ArticleTranslates
    {
        $translate = $this->translates[$language] ?? null;
        if($translate === null) {
            throw new EntityLogicException(
                sprintf(
                    'Translate %s for Article id %s is missing',
                    $language,
                    $this->getId()->toString(),
                )
            );
        }

        return $translate;
    }

    /** @return ArticleTranslates[] */
    public function getAllTranslates(): array{
        return array_values($this->translates);
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
