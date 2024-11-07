<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {

    $container->add(
        \Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter::class,
        new \Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter(
            $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
        )
    );
    $container->add(
        \Romchik38\Site2\Application\ArticleListView\View\ReadLengthFormatterInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter::class)
    );

    return $container;
};
