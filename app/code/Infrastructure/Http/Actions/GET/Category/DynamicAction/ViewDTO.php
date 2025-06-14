<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Actions\GET\Category\DynamicAction;

use Romchik38\Server\Http\Views\Dto\DefaultViewDTO;
use Romchik38\Site2\Application\Category\View\View\CategoryDto;
use Romchik38\Site2\Infrastructure\Http\Views\Html\CreatePaginationInterface;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly CategoryDto $category,
        private readonly CreatePaginationInterface $paginationView,
        public readonly string $articlePageUrl
    ) {
        parent::__construct($name, $description);
    }

    public function showPagination(): string
    {
        return $this->paginationView->create();
    }
}
