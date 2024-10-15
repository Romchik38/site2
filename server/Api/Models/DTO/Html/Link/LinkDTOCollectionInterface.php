<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Html\Link;

interface LinkDTOCollectionInterface
{
    /**
     * @param string $url Http url like /page
     */
    public function getLinkByUrl(string $url): LinkDTOInterface|null;

    /**
     * @return LinkDTOInterface[]
     */
    public function getAllLinks(): array;
}
