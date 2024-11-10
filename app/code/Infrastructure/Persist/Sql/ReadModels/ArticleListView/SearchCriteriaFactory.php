<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView;

use Romchik38\Server\Models\Errors\InvalidArgumentException;
use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\ArticleListView\View\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Application\ArticleListView\View\SearchCriteriaInterface;

final class SearchCriteriaFactory implements SearchCriteriaFactoryInterface
{
    public const DEFAULT_LIMIT = '15';
    public const DEFAULT_OFFSET = '0';
    public const DEFAULT_ORDER_BY_FIELD = 'article_translates.created_at';
    public const DEFAULT_ORDER_BY_DIRECTION = 'ASC';

    public function create(
        string $offset,
        string $limit,
        string $orderByField,
        string $orderByDirection,
        string $language
    ): SearchCriteriaInterface {

        if ($limit === '') {
            $limit = $this::DEFAULT_LIMIT;
        }

        if ($offset === '') {
            $offset = $this::DEFAULT_OFFSET;
        }

        if ($orderByField === '') {
            $orderByField = $this::DEFAULT_ORDER_BY_FIELD;
        }

        if ($orderByDirection === '') {
            $orderByDirection = $this::DEFAULT_ORDER_BY_DIRECTION;
        }

        if (strlen($language) === 0) {
            throw new InvalidArgumentException('param language is empty');
        }

        return new SearchCriteria(
            new Offset($offset),
            new Limit($limit),
            new OrderBy($orderByField, $orderByDirection),
            $language
        );
    }
}
