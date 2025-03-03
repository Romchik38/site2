<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;

return function (Container $container) {

        // DynamicRoot
        $configDynamicRoot = require_once(__DIR__ . '/../config/shared/dynamic_root.php');
        $defaultDynamicRoot = $configDynamicRoot[DynamicRootInterface::DEFAULT_ROOT_FIELD] ??
            throw new RuntimeException('Missing config field: '
                . DynamicRootInterface::DEFAULT_ROOT_FIELD);
        $DynamicRootList = $configDynamicRoot[DynamicRootInterface::ROOT_LIST_FIELD] ??
            throw new RuntimeException('Missing config field: '
                . DynamicRootInterface::ROOT_LIST_FIELD);
    
        $container->add(
            \Romchik38\Server\Services\DynamicRoot\DynamicRoot::class,
            new \Romchik38\Server\Services\DynamicRoot\DynamicRoot(
                $defaultDynamicRoot,
                $DynamicRootList,
                $container->get(\Romchik38\Server\Api\Models\DTO\DynamicRoot\DynamicRootDTOFactoryInterface::class)
            )
        );
        $container->add(
            \Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class,
            $container->get(\Romchik38\Server\Services\DynamicRoot\DynamicRoot::class)
        );
    
        // TRANSLATESTORAGE
        $container->add(
            \Romchik38\Server\Services\Translate\TranslateStorage::class,
            new \Romchik38\Server\Services\Translate\TranslateStorage(
                $container->get(Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelRepositoryInterface::class),
                $container->get(Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOFactoryInterface::class)
            )
        );
        $container->add(
            \Romchik38\Server\Api\Services\Translate\TranslateStorageInterface::class,
            $container->get(\Romchik38\Server\Services\Translate\TranslateStorage::class)
        );
    
        // TRANSLATE
        $container->add(
            \Romchik38\Server\Services\Translate\Translate::class,
            new \Romchik38\Server\Services\Translate\Translate(
                $container->get(\Romchik38\Server\Api\Services\Translate\TranslateStorageInterface::class),
                $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class)
            )
        );
        $container->add(
            \Romchik38\Server\Api\Services\Translate\TranslateInterface::class,
            $container->get(\Romchik38\Server\Services\Translate\Translate::class)
        );

    return $container;
};