<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\DTO\Views\Article\DefaultAction;

interface ViewDTOFactoryInterface
{
    public function create(
        string $name,
        string $description,
        array $articleList = []
    ): ViewDTOInterface;
}
