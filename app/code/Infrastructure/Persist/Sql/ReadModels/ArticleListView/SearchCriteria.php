<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView;

use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Article\ArticleListView\View\SearchCriteriaInterface;

final class SearchCriteria implements SearchCriteriaInterface
{
    public function __construct(
        protected Offset $offset,
        protected Limit $limit,
        protected OrderBy $orderBy,
        protected string $language
    ) {
    }

    public function offset(): Offset
    {
        return $this->offset;
    }

    public function limit(): Limit
    {
        return $this->limit;
    }

    public function orderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function language(): string
    {
        return $this->language;
    }
}
