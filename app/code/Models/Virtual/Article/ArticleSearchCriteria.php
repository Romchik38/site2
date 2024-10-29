<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article;

use Romchik38\Server\Models\SearchCriteria\SearchCriteria;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleSearchCriteriaInterface;

final class ArticleSearchCriteria extends SearchCriteria implements ArticleSearchCriteriaInterface
{

    public function __construct(
        $limit = 'all',
        $offset = '0',
        protected bool|null $active = null
    )
    {
        parent::__construct($limit, $offset);
    }

    public function setActive(bool $active): ArticleSearchCriteriaInterface {
        $this->active = $active;
        return $this;
    }
}
