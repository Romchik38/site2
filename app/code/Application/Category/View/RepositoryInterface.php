<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\View;

use Romchik38\Site2\Application\Category\View\Commands\Filter\SearchCriteria;
use Romchik38\Site2\Application\Category\View\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\View\View\CategoryDto;
use Romchik38\Site2\Application\Category\View\View\CategoryIdNameDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

interface RepositoryInterface
{
    /** @throws RepositoryException */
    public function find(SearchCriteria $searchCriteria): CategoryDto;

    /**
     * @throws RepositoryException
     * @return array<int,CategoryIdNameDto>
     * */
    public function listIdNames(LanguageId $languageId): array;
}
