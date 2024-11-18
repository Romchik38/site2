<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\ArticleListView;

use Romchik38\Site2\Application\ArticleListView\View\ArticleDTO;
use Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface;
use Romchik38\Site2\Application\ArticleListView\View\SearchCriteriaFactoryInterface;

final class ArticleListViewService
{

    public function __construct(
        private readonly ArticleListViewRepositoryInterface $articleListViewRepository,
        private readonly SearchCriteriaFactoryInterface $searchCriteriaFactory
    ) {}

    /** @return array<int,ArticleDTO> */
    public function list(Pagination $command, string $language): array {

        $searchCriteria = $this->searchCriteriaFactory->create(
            $command->offset(),
            $command->limit(),
            $command->orderByField(),
            $command->orderByDirection(),
            $language
        );

        $models = $this->articleListViewRepository->list($searchCriteria);
        
        return $models;
    }

    /** count of all active article */
    public function listTotal(): int {
        return $this->articleListViewRepository->totalCount();
    }
}
