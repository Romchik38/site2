<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Check\Check;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\Find;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Update\Update;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotCheckException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotFindException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotGetLastException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\NoSuchArticleException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\ContinueReading\View\ArticleDto;
use Romchik38\Site2\Application\Article\ContinueReading\View\Item;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class ContinueReading
{
    public function __construct(
        private readonly RepositoryInterface $repository,
        private readonly ItemRepositoryInterface $itemRepository
    ) {
    }

    /** @todo remove if not used */
    /**
     * @throws CouldNotCheckException
     * @throws InvalidArgumentException
     * */
    public function check(Check $command): bool
    {
        $id = new ArticleId($command->id);
        try {
            return $this->repository->checkById($id);
        } catch (RepositoryException $e) {
            throw new CouldNotCheckException($e->getMessage());
        }
    }

    /** @throws CouldNotGetLastException */
    public function getLast(string $language): ?ArticleDto
    {
        $item = $this->itemRepository->get();
        if ($item === null) {
            return null;
        }

        $command = new Find($item->first, $language);

        try {
            return $this->find($command);
        } catch (InvalidArgumentException $e) {
            throw new CouldNotGetLastException($e->getMessage());
        } catch (CouldNotFindException $e) {
            throw new CouldNotGetLastException($e->getMessage());
        } catch (NoSuchArticleException $e) {
            throw new CouldNotGetLastException($e->getMessage());
        }
    }

    /** @todo convert to private */
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

    /**
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     * */
    public function update(Update $command): void
    {
        $findCommand = new Find($command->articleId, $command->languageId);

        try {
            $article = $this->find($findCommand);
        } catch (CouldNotFindException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }

        $item = $this->itemRepository->get();
        if ($item === null) {
            $item = new Item($article->getId());
        } else {
            $item->second = $item->first;
            $item->first  = $article->getId();
        }

        $this->itemRepository->update($item);
    }
}
