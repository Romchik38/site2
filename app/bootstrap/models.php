<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    
    // MODEL FACTORIES
    $container->multi(
        '\Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory',
        '\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface',
        true,
        []
    );

    $container->multi(
        '\Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory',
        '\Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOFactoryInterface',
        true,
        []
    );

    $container->multi(
        '\Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory',
        '\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface',
        true,
        []
    );

    return $container;
};
