<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminList;

use InvalidArgumentException;
use Romchik38\Site2\Application\Audio\AdminList\VO\Limit;
use Romchik38\Site2\Application\Audio\AdminList\VO\Offset;
use Romchik38\Site2\Application\Audio\AdminList\VO\OrderByDirection;
use Romchik38\Site2\Application\Audio\AdminList\VO\OrderByField;
use Romchik38\Site2\Application\Audio\AdminList\VO\Page;

final class AdminList
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotListException
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
            return new FilterResult(
                $searchCriteria,
                $page,
                $list
            );
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }

    public function totalCount(): int
    {
        return $this->repository->totalCount();
    }
}
