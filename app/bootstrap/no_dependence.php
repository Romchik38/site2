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
        \Romchik38\Server\Models\DTO\Language\LanguageDTOFactory::class,
        new \Romchik38\Server\Models\DTO\Language\LanguageDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Language\LanguageDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\Language\LanguageDTOFactory::class)
    );

    return $container;
};