<?php

declare(strict_types=1);

namespace Romchik38\Site2\Persist\Sql\Article;

use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;
use Romchik38\Server\Models\Sql\SearchCriteria\SearchCriteria;

final class ArticleSearchCriteria extends SearchCriteria
{

    public function __construct(
        Limit $limit,
        Offset $offset,
        array $orderBy = []
    ) {
        parent::__construct(
            ArticleRepository::ARTICLE_C_IDENTIFIER,
            ArticleRepository::ARTICLE_T,
            $limit,
            $offset,
            $orderBy
        );
    }

    /** WHERE SECTION 
     * @todo implement
     */

}
