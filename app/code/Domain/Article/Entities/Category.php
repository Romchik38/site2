<?php

declare(strict_types=1);

namespace Romchik38\Site2\Domain\Article\Entities;

use InvalidArgumentException;

use function strlen;

final class Category
{
    public function __construct(
        private string $articleId,
        private string $categoryId,
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

    /** @throws InvalidArgumentException - When string is empty. */
    public function setArticleId(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }
        $this->articleId = $id;
        return $this;
    }

    /** @throws InvalidArgumentException - When string is empty. */
    public function setCategoryId(string $id): self
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Category id field can\'t be empty');
        }
        $this->categoryId = $id;
        return $this;
    }
}
