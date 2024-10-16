<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Html\Link;

interface LinkDTOCollectionInterface
{
    /**
     * @param string[] $path like ['root']
     */
    public function getLinkByPath(array $path): LinkDTOInterface|null;

    /**
     * @return LinkDTOInterface[]
     */
    public function getAllLinks(): array;
}
