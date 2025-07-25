<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Find\SearchCriteria as FindSearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\List\SearchCriteria as ListSearchCriteria;
use Romchik38\Site2\Application\Article\ContinueReading\Commands\Update\Update;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotListException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\CouldNotUpdateException;
use Romchik38\Site2\Application\Article\ContinueReading\Exceptions\ItemRepositoryException;
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

    /**
     * @throws CouldNotListException
     * @return array<int,ArticleDto> - Last visited goes with index 0.
     */
    public function list(string $language): array
    {
        try {
            $item = $this->itemRepository->get();
            if ($item === null) {
                return [];
            }

            $articleIds = [];

            $articleIds[] = new ArticleId($item->first);
            if ($item->second !== null) {
                $articleIds[] = new ArticleId($item->second);
            }
            $languageId     = new LanguageId($language);
            $searchCriteria = new ListSearchCriteria($articleIds, $languageId);
            $articles       = $this->repository->list($searchCriteria);
            $sortedArticles = [];
            foreach ($articles as $article) {
                if ($article->getId() === $item->first) {
                    $sortedArticles[] = $article;
                }
            }
            if ($item->second !== null) {
                foreach ($articles as $article) {
                    if ($article->getId() === $item->second) {
                        $sortedArticles[] = $article;
                    }
                }
            }
            return $sortedArticles;
        } catch (InvalidArgumentException $e) {
            throw new CouldNotListException($e->getMessage());
        } catch (RepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        } catch (ItemRepositoryException $e) {
            throw new CouldNotListException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotUpdateException
     * @throws InvalidArgumentException
     * @throws NoSuchArticleException
     * */
    public function update(Update $command): void
    {
        try {
            $articleId      = new ArticleId($command->articleId);
            $languageId     = new LanguageId($command->languageId);
            $searchCriteria = new FindSearchCriteria($articleId, $languageId);
            $article        = $this->repository->find($searchCriteria);
            $newId          = $article->getId();
            $item           = $this->itemRepository->get();
            if ($item === null) {
                $item = new Item($newId);
            } else {
                if ($newId !== $item->first) {
                    $item->second = $item->first;
                    $item->first  = $newId;
                }
            }
            $this->itemRepository->update($item);
        } catch (RepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        } catch (ItemRepositoryException $e) {
            throw new CouldNotUpdateException($e->getMessage());
        }
    }
}
