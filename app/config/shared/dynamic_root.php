<?php

declare(strict_types=1);

use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;

return [
    DynamicRootInterface::DEFAULT_ROOT_FIELD => 'uk',
    DynamicRootInterface::ROOT_LIST_FIELD => ['en', 'uk']
];