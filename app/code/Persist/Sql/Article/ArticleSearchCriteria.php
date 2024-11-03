<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\Virtual\Article\Sql;

use Romchik38\Server\Models\Sql\SearchCriteria\SearchCriteria;
use Romchik38\Site2\Api\Models\Virtual\Article\ArticleInterface;

final class ArticleSearchCriteria extends SearchCriteria
{


    protected bool|null $active = null;

    public function __construct(
        string $limit = 'all',
        string $offset = '0',
        array $orderBy = []
    ) {
        parent::__construct(
            ArticleRepository::ARTICLE_C_IDENTIFIER,
            ArticleRepository::ARTICLE_T,
            $limit,
            $offset,
            $orderBy
        );
    }

    /** WHERE SECTION 
     * @todo implement
    */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
