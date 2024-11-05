<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Article\Filters;

use Romchik38\Server\Models\Sql\SearchCriteria\Filter;
use Romchik38\Site2\Persist\Sql\Article\ArticleRepository;

final class ArticleFilter extends Filter
{
    public static function active(): self {
        $expression = sprintf(
            '%s.%s = $', 
            ArticleRepository::ARTICLE_T,
            ArticleRepository::ARTICLE_C_ACTIVE
        );
        return new self(
            $expression,
            'true'
        );
    }
}
