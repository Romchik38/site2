<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminList;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\AdminList\Commands\Filter\Filter;
use Romchik38\Site2\Application\Article\AdminList\Commands\Filter\FilterResult;
use Romchik38\Site2\Application\Article\AdminList\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminList\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Article\AdminList\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\AdminList\VO\Limit;
use Romchik38\Site2\Application\Article\AdminList\VO\Offset;
use Romchik38\Site2\Application\Article\AdminList\VO\OrderByDirection;
use Romchik38\Site2\Application\Article\AdminList\VO\OrderByField;
use Romchik38\Site2\Application\Article\AdminList\VO\Page;

final class AdminListService
{
    public function __construct(
        private readonly RepositoryInterface $repository,
    ) {
    }

    /**
     * @throws CouldNotListException
     * @throws InvalidArgumentException
     * */
    public function list(Filter $command): FilterResult
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
            $orderByDirection
        );

        try {
            $list = $this->repository->list($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        }

        return new FilterResult($searchCriteria, $page, $list);
    }

    public function totalCount(): int
    {
        return $this->repository->totalCount();
    }
}
