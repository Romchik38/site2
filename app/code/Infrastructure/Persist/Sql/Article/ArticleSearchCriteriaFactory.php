<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\Article;

use Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface;
use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;

class ArticleSearchCriteriaFactory implements SearchCriteriaFactoryInterface {

    public const DEFAULT_LIMIT = '15';
    public const DEFAULT_OFFSET = '0';

    public function create(
        string $limit,
        string $offset,
        array $orderBy = []
    ): ArticleSearchCriteria {

        if ($limit === '') {
            $limit = $this::DEFAULT_LIMIT;
        }

        if ($offset === '') {
            $offset = $this::DEFAULT_OFFSET;
        }

        return new ArticleSearchCriteria(
            new Limit($limit),
            new Offset($offset),
            $orderBy
        );
    }
}