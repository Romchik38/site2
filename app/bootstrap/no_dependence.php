<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    
    // MODEL FACTORIES
    $container->add(
        \Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory::class,
        new \Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory::class)
    );

    // DTO
    $container->add(
        \Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory::class,
        new \Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory::class,
        new \Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory::class)
    );

    // Controller
    $container->add(
        \Romchik38\Server\Routers\Http\ControllersCollection::class,
        new \Romchik38\Server\Routers\Http\ControllersCollection
    );
    $container->add(
        \Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\ControllersCollection::class)
    );

    // Services
    $container->add(
        \Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorUseRandomBytes::class,
        new \Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorUseRandomBytes(32)
    );
    $container->add(
        \Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Services\TokenGenerators\CsrfTokenGeneratorUseRandomBytes::class)
    );

    return $container;
};
