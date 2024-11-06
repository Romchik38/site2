<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Article\Filters;

use Romchik38\Site2\Domain\Article\ArticleFilterFactoryInterface;

final class ArticleFilterFactory implements ArticleFilterFactoryInterface
{
    public static function active(): ArticleFilter
    {
        return ArticleFilter::active();
    }
}
