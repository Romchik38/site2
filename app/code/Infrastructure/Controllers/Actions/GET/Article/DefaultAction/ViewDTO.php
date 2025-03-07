<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Actions\GET\Article\DefaultAction;

use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Application\ArticleListView\View\ArticleDTO;
use Romchik38\Site2\Infrastructure\Views\Html\CreatePaginationInterface;

final class ViewDTO extends DefaultViewDTO
{
    /** @param array<int,ArticleDTO> $articleList */
    public function __construct(
        string $name,
        string $description,
        protected array $articleList,
        protected readonly CreatePaginationInterface $paginationView,
        public readonly string $articlePageUrl
    ) {
        parent::__construct($name, $description);
    }

    /** @return array<int,ArticleDTO> */
    public function getArticles(): array
    {
        return $this->articleList;
    }

    public function showPagination(): string
    {
        return $this->paginationView->create();
    }
}
