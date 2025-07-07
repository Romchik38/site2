<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\MostVisited;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\MostVisited\Commands\List\Count;
use Romchik38\Site2\Application\Article\MostVisited\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Article\MostVisited\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Article\MostVisited\Exceptions\RepositoryException;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class MostVisited
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotListException
     * @throws InvalidArgumentException
     */
    public function list(int $count, string $language): array
    {
        $searchCriteria = new SearchCriteria(
            new Count($count),
            new LanguageId($language)
        );

        try {
            return $this->repository->list($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }
}
