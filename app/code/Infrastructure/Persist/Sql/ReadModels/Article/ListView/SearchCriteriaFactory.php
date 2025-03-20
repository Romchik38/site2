<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\Article\ListView;

use InvalidArgumentException;
use Romchik38\Server\Models\Sql\SearchCriteria\Limit;
use Romchik38\Server\Models\Sql\SearchCriteria\Offset;
use Romchik38\Server\Models\Sql\SearchCriteria\OrderBy;
use Romchik38\Site2\Application\Article\ArticleListView\View\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Application\Article\ArticleListView\View\SearchCriteriaInterface;

use function in_array;
use function sprintf;
use function strlen;

final class SearchCriteriaFactory implements SearchCriteriaFactoryInterface
{
    public const DEFAULT_LIMIT                  = '15';
    public const DEFAULT_ORDER_BY_FIELD         = 'created_at';
    public const DEFAULT_ORDER_BY_DIRECTION     = 'DESC';
    public const array ACCEPTED_ORDER_BY_FIELDS = [
        'created_at',
        'identifier',
    ];

    public function create(
        string $offset,
        string $limit,
        string $orderByField,
        string $orderByDirection,
        string $language
    ): SearchCriteriaInterface {
        if ($limit === '') {
            $limit = $this::DEFAULT_LIMIT;
        } else {
            $limitInt = (int) $limit;
            if ($limitInt <= 0) {
                throw new InvalidArgumentException(
                    sprintf('param limit %s is incorrect', $limit)
                );
            }
        }

        if ($offset !== '') {
            $offsetInt = (int) $offset;
            if ($offsetInt < 0) {
                throw new InvalidArgumentException(
                    sprintf('param offset %s is incorrect', $offset)
                );
            }
        }

        if ($orderByField === '') {
            $orderByField = $this::DEFAULT_ORDER_BY_FIELD;
        } else {
            if (in_array($orderByField, $this::ACCEPTED_ORDER_BY_FIELDS) === false) {
                throw new InvalidArgumentException(
                    sprintf('param order by field %s is incorrect', $orderByField)
                );
            }
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
