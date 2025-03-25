<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Language\ListView;

use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

interface RepositoryInterface
{
    /** @return array<int,LanguageDto> */
    public function getAll(): array;
}
