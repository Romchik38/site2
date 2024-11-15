<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction;

use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTO;
use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

final class ViewDTO extends DefaultViewDTO
{
    public function __construct(
        string $name,
        string $description,
        protected array $articleList,
        protected readonly CreatePaginationInterface $paginationView,
        protected readonly UrlbuilderInterface $urlbuilder
    ) {
        parent::__construct($name, $description);
    }

    public function getArticles(): array
    {
        return $this->articleList;
    }

    public function showPagination(): string
    {
        return $this->paginationView->create();
    }

    public function urlbuilder(): object
    {
        return new class($this->urlbuilder) {
            public function __construct(
                protected readonly UrlbuilderInterface $urlbuilder
            ) {}
            public function addWithDelimiter($lastPart)
            {
                return $this->urlbuilder->addWithDelimiter($lastPart);
            }
        };
    }
}
