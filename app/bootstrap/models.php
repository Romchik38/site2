<?php

declare(strict_types=1);

use Romchik38\Container\Container;

return function (Container $container) {
    
    // MODEL FACTORIES
    $container->multi(
        '\Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory',
        '\Romchik38\Server\Http\Views\Dto\DefaultViewDTOFactoryInterface',
        true,
        []
    );

    return $container;
};
