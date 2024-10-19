<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Http\LinkTree;

interface LinkTreeDTOFactoryInterface
{
    /**
     * @throws InvalidArgumentException name, description and url length must be greater than 0
     */
    public function create(
        string $name,
        string $description,
        string $url,
        array $children,
        array $parents
    );
}
