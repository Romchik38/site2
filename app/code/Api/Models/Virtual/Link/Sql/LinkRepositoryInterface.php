<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Virtual\Link\Sql;

use Romchik38\Server\Api\Models\Virtual\VirtualRepositoryInterface;
use Romchik38\Site2\Api\Models\Virtual\Link\LinkInterface;

interface LinkRepositoryInterface extends VirtualRepositoryInterface
{
    /** 
     * @param string $language From DynamicRoot
     * @param array<int,array<int,string>> $paths Array of arrays with path parts like [['root'], ...]
     * 
     * @return LinkInterface[]
     */
    public function getLinksByLanguageAndPaths(string $language, array $paths): array;
}
