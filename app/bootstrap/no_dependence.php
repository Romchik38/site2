<?php

declare(strict_types=1);

use Romchik38\Container;


return function(Container $container) {

    // RESULTS 
    $container->add(
        \Romchik38\Server\Results\Controller\ControllerResultFactory::class,
        new \Romchik38\Server\Results\Controller\ControllerResultFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class,
        $container->get(\Romchik38\Server\Results\Controller\ControllerResultFactory::class)    
    );    

    // DTO
    $container->add(
        \Romchik38\Server\Models\DTO\DymanicRoot\DymanicRootDTOFactory::class,
        new \Romchik38\Server\Models\DTO\DymanicRoot\DymanicRootDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\DymanicRoot\DymanicRootDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\DymanicRoot\DymanicRootDTOFactory::class)
    );

    return $container;
};