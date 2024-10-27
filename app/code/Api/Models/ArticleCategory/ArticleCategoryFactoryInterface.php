<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\ArticleCategory;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

interface ArticleCategoryFactoryInterface
{
    /**
     * @throws InvalidArgumentException articleId, categoryId can't be empty
     */
    public function create(
        string $articleId,
        string $categoryId
    ): ArticleCategoryInterface;
}
