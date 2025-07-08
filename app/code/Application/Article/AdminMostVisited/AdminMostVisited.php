<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminMostVisited;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\AdminMostVisited\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Article\AdminMostVisited\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Article\AdminMostVisited\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\AdminMostVisited\Views\ArticleDTO;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class AdminMostVisited
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotListException
     * @throws InvalidArgumentException
     * @return array<int,ArticleDTO>
     */
    public function list(string $language): array
    {
        $searchCriteria = new SearchCriteria(
            new LanguageId($language)
        );

        try {
            return $this->repository->list($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }
}
