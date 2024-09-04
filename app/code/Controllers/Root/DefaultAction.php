<?php

declare(strict_types=1);

namespace Romchik38\Site2\Controllers\Root;

use Romchik38\Server\Api\Controllers\Actions\DefaultActionInterface;
use Romchik38\Server\Controllers\Actions\DynamicRootAction;

class DefaultAction extends DynamicRootAction implements DefaultActionInterface
{

    public function execute(): string
    {
        $currentRoot = $this->dymanicRootService->getCurrentRoot();

        return 'Hello from' . $currentRoot->getName() . ' root ';
    }
}
