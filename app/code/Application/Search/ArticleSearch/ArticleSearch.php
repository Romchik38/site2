<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\ArticleSearch;

use Romchik38\Site2\Application\Search\ArticleSearch\Commands\List\ListCommand;
use Romchik38\Site2\Application\Search\ArticleSearch\View\ArticleDto;
use Romchik38\Site2\Application\Search\ArticleSearch\Commands\List\CouldNotListException;

final class ArticleSearch
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {   
    }
    
    /**
     * @throws CouldNotListException
     * @return array<int,ArticleDto>
     */
    public function list(ListCommand $command): array
    {
        
    }
}