<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\Article\ArticleInterface;

final class Article implements ArticleInterface
{
    public function __construct(
        protected string $articleId,
        protected bool $active
    ) {}

    public function getId(): string
    {
        return $this->articleId;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setId(string $id): ArticleInterface
    {
        if (strlen($id) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }

        $this->articleId = $id;
        return $this;
    }

    public function activate(): ArticleInterface
    {
        $this->active = true;
        return $this;
    }
    public function deactivate(): ArticleInterface
    {
        $this->active = false;
        return $this;
    }
}
