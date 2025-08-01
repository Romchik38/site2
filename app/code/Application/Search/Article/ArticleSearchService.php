<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article;

use InvalidArgumentException;
use Romchik38\Site2\Application\Search\Article\Commands\List\CouldNotListException;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Application\Search\Article\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Search\Article\View\ArticleDto;
use Romchik38\Site2\Application\Search\Article\VO\Query;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use RuntimeException;

final class ArticleSearchService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotListException
     * @throws InvalidArgumentException
     * @return array<int,ArticleDto>
     */
    public function list(ListCommand $command): array
    {
        try {
            $languageId     = new LanguageId($command->language);
            $query          = new Query($command->query);
            $searchCriteria = new SearchCriteria($languageId, $query);
            return $this->repository->list($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        } catch (RuntimeException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }
}
