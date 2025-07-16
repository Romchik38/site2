<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Page\View;

use Romchik38\Site2\Application\Page\View\Commands\Find\SearchCriteria;
use Romchik38\Site2\Application\Page\View\View\ListDto;
use Romchik38\Site2\Application\Page\View\View\PageDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

interface RepositoryInterface
{
    /**
     * @throws NoSuchPageException
     * @throws RepositoryException - On invalid database data.
     * */
    public function find(SearchCriteria $searchCriteria): PageDto;

    /**
     * @throws RepositoryException
     * @return array<int,ListDto>
     * */
    public function list(LanguageId $languageId): array;
}
