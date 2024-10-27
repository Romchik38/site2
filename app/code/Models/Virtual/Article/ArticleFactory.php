<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use Romchik38\Site2\Api\Models\Virtual\Article\ArticleFactoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

class ArticleFactory implements ArticleFactoryInterface
{
    public function create(
        string $articleId,
        bool $active,
        array $translates,
        array $categories
        ): ArticleInterface
    {
        return new Article(
            $articleId,
            $active,
            $translates,
            $categories
        );
    }
}
