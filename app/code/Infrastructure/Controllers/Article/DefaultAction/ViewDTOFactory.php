<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction;

use Romchik38\Server\Api\Services\Urlbuilder\UrlbuilderInterface;
use Romchik38\Site2\Infrastructure\Views\CreatePaginationInterface;

final class ViewDTOFactory
{
    public function create(
        string $name,
        string $description,
        array $articleList,
        CreatePaginationInterface $paginationView,
        UrlbuilderInterface $urlbuilder
    ): ViewDTO {
        return new ViewDTO(
            $name,
            $description,
            $articleList,
            $paginationView,
            $urlbuilder
        );
    }
}
