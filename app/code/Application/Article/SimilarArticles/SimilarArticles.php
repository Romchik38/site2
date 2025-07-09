<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles;

use InvalidArgumentException;
use Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar\ListSimilar;
use Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar\SearchCriteria;
use Romchik38\Site2\Application\Article\SimilarArticles\Exceptions\CouldNotListSimilarException;
use Romchik38\Site2\Application\Article\SimilarArticles\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Article\SimilarArticles\View\ArticleDto;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;

final class SimilarArticles
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws CouldNotListSimilarException
     * @throws InvalidArgumentException
     * @return array<int,ArticleDto>
     */
    public function list(ListSimilar $command): array
    {
        $articleId = new ArticleId($command->articleId);
        if (count($command->categories) === 0) {
            throw new InvalidArgumentException('To search for artiles, you must specify at least one category');
        }
        $categories = [];
        foreach ($command->categories as $category) {
            $categories[] = new CategoryId($category);
        }
        $languageId = new LanguageId($command->language);

        $searchCriteria = new SearchCriteria($articleId, $categories, $languageId);

        try {
            return $this->repository->list($searchCriteria);
        } catch (RepositoryException $e) {
            throw new CouldNotListSimilarException($e->getMessage());
        }
    }
}
