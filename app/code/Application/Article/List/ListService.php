<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\Filter;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\FilterResult;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\SearchCriteria;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\Limit;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\Offset;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\OrderByDirection;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\OrderByField;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\VO\Page;
use Romchik38\Site2\Application\Article\List\RepositoryInterface;

final class ListService
{
    public function __construct(
        private readonly RepositoryInterface $articleListViewRepository
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * */
    public function list(Filter $command, string $language): FilterResult
    {
        $limit            = Limit::fromString($command->limit);
        $page             = Page::fromString($command->page);
        $orderByField     = new OrderByField($command->orderByField);
        $orderByDirection = new OrderByDirection($command->orderByDirection);
        $offset           = new Offset(($page() - 1) * $limit());

        $searchCriteria = new SearchCriteria(
            $offset,
            $limit,
            $orderByField,
            $orderByDirection,
            $language
        );

        $list = $this->articleListViewRepository->list($searchCriteria);

        return new FilterResult($searchCriteria, $page, $list);
    }

    /** count of all active article */
    public function listTotal(): int
    {
        return $this->articleListViewRepository->totalCount();
    }
}
