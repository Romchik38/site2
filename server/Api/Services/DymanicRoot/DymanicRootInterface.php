<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Services\DymanicRoot;

use Romchik38\Server\Api\Models\DTO\DymanicRoot\DymanicRootDTOInterface;

interface DymanicRootInterface
{
    const DEFAULT_ROOT_FIELD = 'default_root';
    const ROOT_LIST_FIELD = 'root_list';

    /** return default root */
    public function getDefaultRoot(): DymanicRootDTOInterface;

    /** 
     * return a list of root entities
     * the list defined in the config file
     * 
     * @return DymanicRootDTOInterface[]
     */
    public function getRootList(): array;

    /** 
     * @return string[] all root names from the list
     */
    public function getRootNames(): array;
}
