<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\ArticleCategory;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryFactoryInterface;
use Romchik38\Site2\Api\Models\ArticleCategory\ArticleCategoryInterface;

final class ArticleCategoryFactory implements ArticleCategoryFactoryInterface
{
    public function create(string $articleId, string $categoryId): ArticleCategoryInterface
    {
        if (strlen($articleId) === 0 || strlen($categoryId) === 0) {
            throw new InvalidArgumentException('params articleId, categoryId can\'t be empty');
        }

        return new ArticleCategory(
            $articleId,
            $categoryId
        );
    }
}
