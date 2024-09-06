<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function (Container $container) {

    // DymanicRoot
    $configDymanicRoot = require_once(__DIR__ . '/../config/shared/dymanic_root.php');
    $defaultDymanicRoot = $configDymanicRoot[DymanicRootInterface::DEFAULT_ROOT_FIELD] ??
        throw new MissingRequiredParameterInFileError('Missing config field: '
            . DymanicRootInterface::DEFAULT_ROOT_FIELD);
    $dymanicRootList = $configDymanicRoot[DymanicRootInterface::ROOT_LIST_FIELD] ??
        throw new MissingRequiredParameterInFileError('Missing config field: '
            . DymanicRootInterface::ROOT_LIST_FIELD);

    $container->add(
        \Romchik38\Server\Services\DymanicRoot\DymanicRoot::class,
        new \Romchik38\Server\Services\DymanicRoot\DymanicRoot(
            $defaultDymanicRoot,
            $dymanicRootList,
            $container->get(\Romchik38\Server\Api\Models\DTO\DymanicRoot\DymanicRootDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface::class,
        $container->get(\Romchik38\Server\Services\DymanicRoot\DymanicRoot::class)
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
    

    return $container;
};
