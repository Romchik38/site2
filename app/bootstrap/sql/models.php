<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $container->multi(
        '\Romchik38\Server\Models\TranslateEntity\Sql\TranslateEntityModelRepository',
        '\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface'),
            new Promise('\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface'),
            'translate_entities',
            'entity_id'
        ]
    );

    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\AdminUser\AdminUserRepository',
        '\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface')
        ]
    );

    return $container;
};
