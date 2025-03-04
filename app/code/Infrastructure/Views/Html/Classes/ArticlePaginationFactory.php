<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html\Classes;

use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Views\CreatePaginationFactoryInterface;
use Romchik38\Site2\Infrastructure\Views\PaginationInterface;

class ArticlePaginationFactory implements CreatePaginationFactoryInterface
{
    /** @refactor */
    public function create(
        UrlbuilderInterface $urlbuilder,
        PaginationInterface $pagination,
        int $displayed
    ): ArticlePagination {
        return new ArticlePagination(
            $urlbuilder,
            $pagination,
            $displayed
        );
    }
}
