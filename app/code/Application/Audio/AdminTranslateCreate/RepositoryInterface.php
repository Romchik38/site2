<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Audio\AdminTranslateCreate;

use Romchik38\Site2\Application\Audio\AdminTranslateCreate\View\TranslateDto;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @throws NoSuchTranslateException
     */
    public function find(SearchCriteria $searchCriteria): TranslateDto;
}
