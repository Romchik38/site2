<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Models\SearchCriteria\SearchCriteria;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleRepositoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaInterface;
use Romchik38\Site2\Models\Virtual\Article\Sql\ArticleRepository;

final class ArticleSearchCriteria extends SearchCriteria implements ArticleSearchCriteriaInterface
{
    protected bool|null $active = null;

    public function __construct(
        string $limit = 'all',
        string $offset = '0',
        array $orderBy = []
    ) {
        parent::__construct(
            ArticleInterface::ID_FIELD,
            ArticleRepository::T_ARTICLE,
            $limit,
            $offset,
            $orderBy
        );
    }

    public function setActive(bool $active): ArticleSearchCriteriaInterface
    {
        $this->active = $active;
        return $this;
    }
}
