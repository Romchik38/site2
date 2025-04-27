<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Language\List;

use Romchik38\Site2\Application\Language\List\Exceptions\RepositoryException;
use Romchik38\Site2\Application\Language\List\View\LanguageDto;

final class ListViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {
    }

    /**
     * @throws RepositoryException
     * @return array<int,LanguageDto>
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }
}
