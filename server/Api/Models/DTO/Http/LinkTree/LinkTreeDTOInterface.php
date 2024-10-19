<?php

declare(strict_types=1);

namespace Romchik38\Server\Api\Models\DTO\Http\LinkTree;

use Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOInterface;

/**
 * represents a controller's tree
 * 
 * LinkTreeDTOFactoryInterface is responsable to create this entity
 */
interface LinkTreeDTOInterface extends LinkDTOInterface
{
    const PARENTS_FIELD = 'parrents';
    const CHILDREN_FIELD = 'children';

    /** 
     * @return LinkTreeDTOInterface[]
     */
    public function getParents(): array;

    /** 
     * @return LinkTreeDTOInterface[]
     */
    public function getChildren(): array;
}
