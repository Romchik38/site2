<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    // Factories

    $container->add(
        \Romchik38\Domain\Article\Detail\ArticleDTOFactory::class,
        new \Romchik38\Domain\Article\Detail\ArticleDTOFactory(
            $container->get(\Romchik38\Site2\Api\Services\DateFormatterInterface::class),
            $container->get(\Romchik38\Site2\Api\Services\ReadLengthFormatterInterface::class)
        )
    );

    return $container;
};