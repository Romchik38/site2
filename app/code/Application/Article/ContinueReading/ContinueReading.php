<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\Find;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\View\ArticleDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ContinueReading
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotFindException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     */
    public function find(Find $command): ArticleDto
    {
        $articleId  = new ArticleId($command->articleId);
        $languageId = new LanguageId($command->languageId);

        $searchCriteria = new SearchCriteria($articleId, $languageId);

        try {
            return $this->repository->find($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotFindException($e->getMessage());
        }
    }
}
