<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function (Container $container) {

    // ArticleListViewRepository
    $container->add(
        \Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\ArticleListViewRepository::class,
        new \Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\ArticleListViewRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            new \Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory(
                new \Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat,
                new \Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter(
                    $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class)
                )
            )
        ),
    );
    $container->add(
        \Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\ArticleListViewRepository::class)
    );

    return $container;
};
