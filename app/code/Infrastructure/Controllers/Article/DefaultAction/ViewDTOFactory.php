<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Controllers\Article\DefaultAction;

final class ViewDTOFactory
{
    public function create(
        string $name,
        string $description,
        PaginationDTO $pagination,
        array $articleList = []
    ): ViewDTO {
        return new ViewDTO(
            $name,
            $description,
            $pagination,
            $articleList
        );
    }
}
