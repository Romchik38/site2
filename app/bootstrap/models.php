<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    // Factories

    $container->add(
        \Romchik38\Site2\Models\DTO\Article\ArticleDTOFactory::class,
        new \Romchik38\Site2\Models\DTO\Article\ArticleDTOFactory(
            $container->get(
                \Romchik38\Site2\Api\Services\DateFormatterInterface::class
            )
        )
    );
    $container->add(
        \Romchik38\Site2\Api\Models\DTO\Article\ArticleDTOFactoryInterface::class,
        $container->get(\Romchik38\Site2\Models\DTO\Article\ArticleDTOFactory::class)
    );

    return $container;
};