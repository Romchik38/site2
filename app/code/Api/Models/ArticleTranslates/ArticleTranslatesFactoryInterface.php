<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\ArticleTranslates;

interface ArticleTranslatesFactoryInterface
{
    public function create(
        string $articleId,
        string $language,
        string $name,
        string $description,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ): ArticleTranslatesInterface;
}
