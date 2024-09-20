<?php

declare(strict_types=1);

return function ($container) {

    // Root
    $container->add(
        \Romchik38\Site2\Controllers\Root\DefaultAction::class,
        new \Romchik38\Site2\Controllers\Root\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            $container->get(\Romchik38\Site2\Views\Html\TwigView::class),
            $container->get(\Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Controllers\Root\DynamicAction::class,
        new \Romchik38\Site2\Controllers\Root\DynamicAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    // ServerError
    $container->add(
        \Romchik38\Site2\Controllers\ServerError\DefaultAction::class,
        new \Romchik38\Site2\Controllers\ServerError\DefaultAction(
            $container->get(\Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface::class),
            $container->get(Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );

    return $container;
};