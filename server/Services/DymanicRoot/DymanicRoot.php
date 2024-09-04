<?php

declare(strict_types=1);

namespace Romchik38\Server\Services\DymanicRoot;

use Romchik38\Server\Api\Models\DTO\DymanicRoot\DymanicRootDTOFactoryInterface;
use Romchik38\Server\Api\Models\DTO\DymanicRoot\DymanicRootDTOInterface;
use Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface;

class DymanicRoot implements DymanicRootInterface
{
    protected readonly DymanicRootDTOInterface $defaultRoot;

    /**
     * @var DymanicRootDTOInterface[] $rootList
     */
    protected readonly array $rootList;

    public function __construct(
        string $defaultRootName,
        array $rootNamesList,
        DymanicRootDTOFactoryInterface $dymanicRootDTOFactory
    ) {
        $this->defaultRoot = $dymanicRootDTOFactory->create($defaultRootName);
        $list = [];
        foreach ($rootNamesList as $rootName) {
            $rootDTO = $dymanicRootDTOFactory->create($rootName);
            $list[] = $rootDTO;
        }
        $this->rootList = $list;
    }

    public function getDefaultRoot(): DymanicRootDTOInterface
    {
        return $this->defaultRoot;
    }

    public function getRootList(): array
    {
        return $this->rootList;
    }

    public function getRootNames(): array
    {
        $names = [];
        foreach ($this->rootList as $root) {
            $names[] = $root->getName();
        }
        return $names;
    }
}
