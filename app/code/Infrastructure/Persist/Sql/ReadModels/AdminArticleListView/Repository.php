<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\AdminArticleListView;

use Romchik38\Server\Api\Models\DatabaseInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\RepositoryInterface;
use Romchik38\Site2\Application\Article\AdminArticleListView\SearchCriteria;

final class Repository implements RepositoryInterface
{
    public function __construct(
        protected readonly DatabaseInterface $database
    ) {  
    }
    
    public function list(SearchCriteria $searchCriteria): array
    {
        return ['hello world'];
    }
}
