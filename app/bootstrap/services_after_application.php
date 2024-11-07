<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    // Breadcramb
    $container->add(
        \Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb::class,
        new \Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb(
            $container->get(\Romchik38\Server\Api\Services\Mappers\SitemapInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\Breadcrumb\BreadcrumbDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );

    // Link Tree
    $container->add(
        \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class,
        new \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree(
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );

    return $container;
};