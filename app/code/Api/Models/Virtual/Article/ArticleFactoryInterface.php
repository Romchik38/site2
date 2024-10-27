<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Article;

interface ArticleFactoryInterface
{
    /** @param ArticleTranslatesInterface[] $translates */
    public function create(
        string $articleId,
        bool $active,
        array $translates
        ): ArticleInterface;
}
