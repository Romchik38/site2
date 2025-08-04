<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Search\Article;

use InvalidArgumentException;
use Romchik38\Site2\Application\Search\Article\Commands\List\CouldNotListException;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListCommand;
use Romchik38\Site2\Application\Search\Article\Commands\List\SearchCriteria;
use Romchik38\Site2\Application\Search\Article\Commands\List\SearchResult;
use Romchik38\Site2\Application\Search\Article\VO\Limit;
use Romchik38\Site2\Application\Search\Article\VO\Offset;
use Romchik38\Site2\Application\Search\Article\VO\Page;
use Romchik38\Site2\Application\Search\Article\VO\Query;
use Romchik38\Site2\Application\Search\Article\Commands\List\ListResult;
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
     */
    public function list(ListCommand $command): ListResult
    {
        try {
            $languageId     = new LanguageId($command->language);
            $query          = new Query($command->query);
            $page           = Page::fromString($command->page);
            $limit          = new Limit(Limit::DEFAULT_LIMIT);
            $offset         = new Offset(($page() - 1) * $limit());
            $searchCriteria = new SearchCriteria(
                $languageId,
                $query,
                $limit,
                $offset
            );
            $searchResult = $this->repository->list($searchCriteria);
            return new ListResult($searchResult, $page);
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        } catch (RuntimeException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }
}
