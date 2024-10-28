<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\ArticleTranslates;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

interface ArticleTranslatesFactoryInterface
{
    /** @throws InvalidArgumentException articleId, language can\'t be empty */
    public function create(
        string $articleId,
        string $language,
        string $name,
        string $shortDescription,
        string $description,
        \DateTime $createdAt,
        \DateTime $updatedAt
    ): ArticleTranslatesInterface;
}
