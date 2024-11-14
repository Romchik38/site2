<?php

declare(strict_types=1);

return function ($container) {

    // REQUEST
    $container->add(
        \Romchik38\Server\Services\Request\Http\Request::class,
        new \Romchik38\Server\Services\Request\Http\Request(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface::class)    
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Request\Http\RequestInterface::class,
        $container->get(\Romchik38\Server\Services\Request\Http\Request::class)
    );

    $container->add(
        \Romchik38\Server\Services\Request\Http\ServerRequest::class,
        new \Romchik38\Server\Services\Request\Http\ServerRequest(
            $container->get(\Romchik38\Server\Api\Services\Request\Http\UriFactoryInterface::class),
            
        )
    );

    // LINKTREE
    $container->add(
        \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class,
        new \Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree(
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOFactoryInterface::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOCollectionInterface::class),
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Mappers\LinkTree\Http\LinkTreeInterface::class,
        $container->get(\Romchik38\Server\Services\Mappers\LinkTree\Http\LinkTree::class)
    );

    return $container;
};