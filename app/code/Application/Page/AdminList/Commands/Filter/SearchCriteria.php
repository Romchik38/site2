<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\AdminList\Commands\Filter;

use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\Limit;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\Offset;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\OrderByDirection;
use Romchik38\Site2\Application\Page\AdminList\Commands\Filter\VO\OrderByField;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

final class SearchCriteria
{
    public function __construct(
        public readonly Offset $offset,
        public readonly Limit $limit,
        public readonly OrderByField $orderByField,
        public readonly OrderByDirection $orderByDirection,
        public readonly LanguageId $languageId
    ) {
    }
}
