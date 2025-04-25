<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Translate\ListView;

use InvalidArgumentException;
use Romchik38\Site2\Application\Translate\ListView\Exceptions\CouldNotCountException;
use Romchik38\Site2\Application\Translate\ListView\Exceptions\CouldNotFilterException;
use Romchik38\Site2\Application\Translate\ListView\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Translate\ListView\VO\Limit;
use Romchik38\Site2\Application\Translate\ListView\VO\Offset;
use Romchik38\Site2\Application\Translate\ListView\VO\OrderByDirection;
use Romchik38\Site2\Application\Translate\ListView\VO\OrderByField;
use Romchik38\Site2\Application\Translate\ListView\VO\Page;

final class ListViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFilterException
     * @throws InvalidArgumentException
     */
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
            throw new CouldNotFilterException($e->getMessage());
        }
        return new FilterResult($searchCriteria, $page, $list);
    }

    /**
     * @throws CouldNotCountException
     */
    public function totalCount(): int
    {
        try {
            return $this->repository->totalCount();
        } catch (RepositoryException $e) {
            throw new CouldNotCountException($e->getMessage());
        }
    }
}
