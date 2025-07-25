<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\ContinueReading\Commands\Find;

use Romchik38\Site2\Domain\Article\VO\Identifier as ArticleId;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

/** @todo remove if not used */
final class SearchCriteria
{
    public function __construct(
        public readonly ArticleId $articleId,
        public readonly LanguageId $languageId
    ) {
    }
}
