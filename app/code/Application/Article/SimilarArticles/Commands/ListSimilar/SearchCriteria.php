<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\SimilarArticles\Commands\ListSimilar;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Category\VO\Identifier as CategoryId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class SearchCriteria
{
    /** @var array<int,CategoryId> $categories */
    public readonly array $categories;

    /**
     * @param array<int,CategoryId|mixed> $categories
     * @throws InvalidArgumentException
     * */
    public function __construct(
        public readonly ArticleId $articleId,
        array $categories,
        public readonly LanguageId $languageId,
        public readonly Count $count
    ) {
        foreach ($categories as $category) {
            if (! $category instanceof CategoryId) {
                throw new InvalidArgumentException('Param similar article category id is invalid');
            }
        }
        $this->categories = $categories;
    }
}
