<?php

declare(strict_types=1);

use Romchik38\Container;
use Romchik38\Server\Config\Errors\MissingRequiredParameterInFileError;

return function (Container $container) {

    $configImg = require_once(__DIR__ . '/../config/shared/images.php');
    $configImgFolderFrontend =  $configImg['img-folder-frontend'] ?? 
        throw new MissingRequiredParameterInFileError('Missing config field: img-folder-frontend');
        
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

    // Article View Repository
    $container->add(
        \Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView\ArticleViewRepository::class,
        new \Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView\ArticleViewRepository(
            $container->get(\Romchik38\Server\Api\Models\DatabaseInterface::class),
            new Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory(
                new \Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat,
                $container->get(\Romchik38\Server\Api\Services\Translate\TranslateInterface::class),
            ),
            new Romchik38\Site2\Application\ArticleView\View\ImageDTOFactory($configImgFolderFrontend)
        )
    );
    $container->add(
        \Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface::class,
        $container->get(\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView\ArticleViewRepository::class)
    );

    return $container;
};
