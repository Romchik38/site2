<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\Link\Sql;

use Romchik38\Server\Api\Models\RepositoryInterface;

interface LinkRepositoryInterface extends RepositoryInterface
{
    /** 
     * @param string $language From DynamicRoot
     * @return LinkInterface[]
     */
    public function getLinksByLanguage(string $language): array;
}
