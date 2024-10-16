<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Html\Link;

interface LinkDTOCollectionInterface
{
    /**
     * @param array<int,array<string>> $path like [['root'], ['root', 'about']]
     * @return LinkDTOInterface[]
     */
    public function getLinksByPaths(array $paths): array;

    /**
     * @return LinkDTOInterface[]
     */
    public function getAllLinks(): array;
}
