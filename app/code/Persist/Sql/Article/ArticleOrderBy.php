<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

final class ArticleOrderBy extends OrderBy
{
    final public static function byArtileId(
        string $direction = self::ASC_DIRECTION,
        string $nulls = self::NULLS_LAST_OPTION
    ): self {
        return new self(
            ArticleInterface::ID_FIELD,
            $direction,
            $nulls
        );
    }
}
