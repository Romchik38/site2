<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View\Commands\Find;

use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;
use Romchik38\Site2\Domain\Page\VO\Id as PageId;

final class SearchCriteria
{
    public function __construct(
        public readonly PageId $pageId,
        public readonly LanguageId $languageId
    ) {
    }
}
