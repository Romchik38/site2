<?php

declare(strict_types=1);

namespace Romchik38\Site2\Models\DTO\Views\Article\DefaultAction;

use Romchik38\Site2\Api\Models\DTO\Views\Article\DefaultAction\ViewDTOFactoryInterface;
use Romchik38\Site2\Api\Models\DTO\Views\Article\DefaultAction\ViewDTOInterface;

final class ViewDTOFactory implements ViewDTOFactoryInterface
{
    public function create(
        string $name,
        string $description,
        array $articleList = []
    ): ViewDTOInterface {
        return new ViewDTO(
            $name,
            $description,
            $articleList
        );
    }
}
