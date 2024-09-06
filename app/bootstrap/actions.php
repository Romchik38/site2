<?php

declare(strict_types=1);

return function ($container) {

    // Root
    $container->add(
        \Romchik38\Site2\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site2\Controllers\Root\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DymanicRoot\DymanicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    // ServerError
    $container->add(
        \Romchik38\Site2\Controllers\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Controllers\ServerError\DefaultAction()
    );

    return $container;
};