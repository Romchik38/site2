<?php

declare(strict_types=1);

use Romchik38\Container;


return function (Container $container) {

    // RESULTS 
    $container->add(
        \Romchik38\Server\Results\Controller\ControllerResultFactory::class,
        new \Romchik38\Server\Results\Controller\ControllerResultFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class,
        $container->get(\Romchik38\Server\Results\Controller\ControllerResultFactory::class)
    );

    // MODEL FACTORIES
    $container->add(
        \Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory::class,
        new \Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory::class)
    );

    // DTO
    $container->add(
        \Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTOFactory::class,
        new \Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\DynamicRoot\DynamicRootDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory::class,
        new \Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory()
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory::class)
    );

    return $container;
};
