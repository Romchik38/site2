<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;

return function (Container $container) {

    // DynamicRoot
    $configDynamicRoot = require_once(__DIR__ . '/../config/shared/dynamic_root.php');
    $defaultDynamicRoot = $configDynamicRoot[DynamicRootInterface::DEFAULT_ROOT_FIELD] ??
        throw new RuntimeException('Missing config field: '
            . DynamicRootInterface::DEFAULT_ROOT_FIELD);
    $DynamicRootList = $configDynamicRoot[DynamicRootInterface::ROOT_LIST_FIELD] ??
        throw new RuntimeException('Missing config field: '
            . DynamicRootInterface::ROOT_LIST_FIELD);

    $container->multi(
        '\Romchik38\Server\Services\DynamicRoot\DynamicRoot',
        '\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface',
        true,
        [
            $defaultDynamicRoot,
            $DynamicRootList
        ]
    );

    // TRANSLATESTORAGE
    $container->multi(
        '\Romchik38\Server\Services\Translate\TranslateStorage',
        '\Romchik38\Server\Api\Services\Translate\TranslateStorageInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelRepositoryInterface'),
            new Promise('\Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOFactoryInterface')
        ]
    );

    // TRANSLATE
    $container->multi(
        '\Romchik38\Server\Services\Translate\Translate',
        '\Romchik38\Server\Api\Services\Translate\TranslateInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Services\Translate\TranslateStorageInterface'),
            new Promise('\Romchik38\Server\Services\DynamicRoot\DynamicRootInterface')
        ]
    );
    
    return $container;
};