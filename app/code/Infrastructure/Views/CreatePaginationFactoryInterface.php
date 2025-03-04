<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views;

use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderInterface;

interface CreatePaginationFactoryInterface
{
    /** @todo refactor */
    public function create(
        UrlbuilderInterface $urlbuilder,
        PaginationInterface $pagination,
        int $displayed
    ): CreatePaginationInterface;
}
