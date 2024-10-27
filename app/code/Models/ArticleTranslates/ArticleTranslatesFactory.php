<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\ArticleTranslates;

use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleTranslates\ArticleTranslatesInterface;

final class ArticleTranslatesFactory implements ArticleTranslatesFactoryInterface
{
    public function create(
        string $articleId,
        string $language,
        string $name,
        string $description,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ): ArticleTranslatesInterface {
        return new ArticleTranslates(
            $articleId,
            $language,
            $name,
            $description,
            $createdAt,
            $updatedAt
        );
    }
}
