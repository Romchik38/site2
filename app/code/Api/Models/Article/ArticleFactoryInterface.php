<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Article;

use Romchik38\Server\Models\Errors\InvalidArgumentException;

interface ArticleFactoryInterface
{
    /** @throws InvalidArgumentException */
    public function create(
        string $articleId,
        bool $active,
    ): ArticleInterface;
}
