<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Category\List;

use Romchik38\Site2\Application\Category\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Category\List\View\CategoryDto;
use Romchik38\Site2\Domain\Language\VO\Identifier as LanguageId;

interface RepositoryInterface
{
    /**
     * @throws RepositoryException
     * @return array<int,CategoryDto>
     * */
    public function list(LanguageId $languageId): array;
}
