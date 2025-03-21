<?php

declare(strict_types=1);

namespace Romchik38\Site2\Application\Language\ListView;

use Romchik38\Site2\Application\Language\ListView\View\LanguageDto;

final class ListViewService
{
    public function __construct(
        private readonly RepositoryInterface $repository
    ) {  
    }

    /** 
     * @return array<int,LanguageDto>
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }
}
