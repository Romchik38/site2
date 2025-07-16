<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\Commands\Find;

use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\VO\Url;

final class SearchCriteria
{
    public function __construct(
        public readonly Url $url,
        public readonly LanguageId $languageId
    ) {
    }
}
