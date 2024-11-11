<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        public readonly PaginationDTO $pagination,
        protected array $articleList
    ) {
        parent::__construct($name, $description);
    }

    public function getArticles(): array
    {
        return $this->articleList;
    }
}
