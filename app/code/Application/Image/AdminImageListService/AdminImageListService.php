<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Image\AdminImageListService;

use Romchik38\Site2\Application\Image\AdminImageListService\VO\Page;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\Limit;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\Offset;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByField;
use Romchik38\Site2\Application\Image\AdminImageListService\VO\OrderByDirection;

final class AdminImageListService
{
    public function __construct(
        protected readonly RepositoryInterface $repository,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws RepositoryException - On database structure error
     * @return FilterResult 
     * */
    public function list(Filter $command): FilterResult 
    {
        $limit = Limit::fromString($command->limit);
        $page = Page::fromString($command->page);
        $orderByField = new OrderByField($command->orderByField);
        $orderByDirection = new OrderByDirection($command->orderByDirection);
        $offset = new Offset(($page() -1) * $limit());

        $searchCriteria = new SearchCriteria(
            $offset,
            $limit,
            $orderByField,
            $orderByDirection
        );
        
        return new FilterResult(
            $searchCriteria,
            $page,
            $this->repository->list($searchCriteria)
        );
    }

    public function totalCount(): int
    {
        return $this->repository->totalCount();
    }
}