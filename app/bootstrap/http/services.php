<?php

declare(strict_types=1);

return function ($container) {
    // LINKTREE
    $container->add(
        \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class,
        new \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree(
            $container->get(Romchik38\Server\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface::class,
        $container->get(\Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class)
    );

    return $container;
};