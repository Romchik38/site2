<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Article\AdminMostVisited\Commands\List;

use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class SearchCriteria
{
    public function __construct(
        public readonly LanguageId $language
    ) {
    }
}
