<?php

declare(strict_types=1);

namespace Romchik38\Site2\Persist\Sql\Article;

use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;

final class ArticleOrderBy extends OrderBy
{
    final public static function byArtileId(
        string $direction = self::ASC_DIRECTION,
        string $nulls = self::NULLS_LAST_OPTION
    ): self {
        return new self(
            ArticleRepository::ARTICLE_C_IDENTIFIER,
            $direction,
            $nulls
        );
    }
}
