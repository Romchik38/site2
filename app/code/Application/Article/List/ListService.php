<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\List;

use Romchik38\Site2\Application\Article\List\Commands\Pagination\ArticleDTO;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\Pagination;
use Romchik38\Site2\Application\Article\List\Commands\Pagination\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Application\Article\List\RepositoryInterface;

final class ListService
{
    public function __construct(
        private readonly RepositoryInterface $articleListViewRepository,
        private readonly SearchCriteriaFactoryInterface $searchCriteriaFactory
    ) {
    }

    /** @return array<int,ArticleDTO> */
    public function list(Pagination $command, string $language): array
    {
        $searchCriteria = $this->searchCriteriaFactory->create(
            $command->offset(),
            $command->limit(),
            $command->orderByField(),
            $command->orderByDirection(),
            $language
        );

        return $this->articleListViewRepository->list($searchCriteria);
    }

    /** count of all active article */
    public function listTotal(): int
    {
        return $this->articleListViewRepository->totalCount();
    }
}
