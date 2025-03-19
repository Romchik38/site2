<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article;

use InvalidArgumentException;

use function strlen;

final class ArticleCategory
{
    public function __construct(
        protected string $articleId,
        protected string $categoryId,
    ) {
    }

    public function getArticleId(): string
    {
        return $this->articleId;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /** @throws InvalidArgumentException when string is empty */
    public function setArticleId(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }
        $this->articleId = $id;
        return $this;
    }

    /** @throws InvalidArgumentException when string is empty */
    public function setCategoryId(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Category id field can\'t be empty');
        }
        $this->categoryId = $id;
        return $this;
    }
}
