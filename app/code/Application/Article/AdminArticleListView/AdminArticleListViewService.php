<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminArticleListView;

use Romchik38\Site2\Application\Article\AdminArticleListView\View\RepositoryInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\View\SearchCriteriaFactoryInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\View\ArticleDto;

final class AdminArticleListViewService
{
    public function __construct(
        protected readonly RepositoryInterface $repository,
        private readonly SearchCriteriaFactoryInterface $searchCriteriaFactory
    ) {
    }

    /** @return array<int,ArticleDto> */
    public function list(Pagination $command): array {
        $searchCriteria = $this->searchCriteriaFactory->create(
            $command->offset(),
            $command->limit(),
            $command->orderByField(),
            $command->orderByDirection()
        );
        
        return $this->repository->list($searchCriteria);
    }
}