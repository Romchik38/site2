<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\Commands\List;

use InvalidArgumentException;
use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

use function count;

final class SearchCriteria
{
    /** @var array<int,ArticleId> $articles */
    public readonly array $articles;

    /**
     * @param array<int,ArticleId|mixed> $articles
     * @throws InvalidArgumentException
     * */
    public function __construct(
        array $articles,
        public readonly LanguageId $languageId
    ) {
        foreach ($articles as $article) {
            if (! $article instanceof ArticleId) {
                throw new InvalidArgumentException('Param article id is invalid');
            }
        }
        if (count($articles) === 0) {
            throw new InvalidArgumentException('Param article id list is empty');
        }
        $this->articles = $articles;
    }
}
