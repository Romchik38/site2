<?php

declare(strict_types=1);

namespace Romchik38\Server\Models\DTO\Http\LinkTree;

use Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOInterface;
use Romchik38\Server\Models\DTO\Http\Link\LinkDTO;

class LinkTreeDTO extends LinkDTO implements LinkTreeDTOInterface
{
    public function __construct(
        string $name,
        string $description,
        string $url,
        array $children,
        array $parents
    ) {
        parent::__construct($name, $description, $url);
        $this->data[LinkTreeDTOInterface::CHILDREN_FIELD] = $children;
        $this->data[LinkTreeDTOInterface::PARENTS_FIELD] = $parents;
    }

    public function getParents(): array
    {
        return $this->data[LinkTreeDTOInterface::PARENTS_FIELD];
    }

    public function getChildren(): array
    {
        return $this->data[LinkTreeDTOInterface::CHILDREN_FIELD];
    }
}
