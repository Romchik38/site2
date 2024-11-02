<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Site2\Api\Models\Article\ArticleFactoryInterface;
use Romchik38\Site2\Api\Models\Article\ArticleInterface;

class ArticleFactory implements ArticleFactoryInterface
{
    public function create(
        string $articleId,
        bool $active,
    ): ArticleInterface {

        if (strlen($articleId) === 0) {
            throw new InvalidArgumentException('Article id field can\'t be empty');
        }

        return new Article(
            $articleId,
            $active
        );
    }
}
