<?php

declare(strict_types=1);

use Romchik38\Container\Container;
use Romchik38\Container\Promise;

return function (Container $container) {

    $configImg = require_once(__DIR__ . '/../config/shared/images.php');
    $configImgFolderFrontend =  $configImg['img-folder-frontend'] ??
        throw new RuntimeException('Missing config field: img-folder-frontend');

    $configAudio = require_once(__DIR__ . '/../config/shared/audio.php');
    $configAudioFolderFrontend =  $configAudio['audio-folder-frontend'] ??
        throw new RuntimeException('Missing config field: audio-folder-frontend');

    // ArticleListViewRepository
    /** @todo move to sql */
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\ArticleListViewRepository',
        '\Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface'),
            new Promise('\Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory'),
            new Promise('\Romchik38\Site2\Application\ArticleListView\View\ImageDTOFactory')
        ]
    );

    /** @todo move to application */
    $container->shared(
        '\Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory',
        [
            new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter')
        ]
    );
    $container->shared('\Romchik38\Site2\Application\ArticleListView\View\ImageDTOFactory', [$configImgFolderFrontend]);

    /** @todo move to service */
    $container->shared('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat', []);
    $container->shared('\Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter', [
        new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
    ]);


    // Article View Repository
    /** @todo move to sql */
    $container->multi(
        '\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleView\ArticleViewRepository',
        '\Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface',
        true,
        [
            new Promise('\Romchik38\Server\Api\Models\DatabaseInterface'),
            new Promise('\Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory'),
            new Promise('\Romchik38\Site2\Application\ArticleView\View\ImageDTOFactory'),
            new Promise('\Romchik38\Site2\Application\ArticleView\View\AudioDTOFactory')
        ]
    );

    /** @todo move to application */
    $container->shared('\Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory', [
        new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
        new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
    ]);
    
    $container->shared('\Romchik38\Site2\Application\ArticleView\View\ImageDTOFactory', [$configImgFolderFrontend]);
    $container->shared('\Romchik38\Site2\Application\ArticleView\View\AudioDTOFactory', [$configAudioFolderFrontend]);

    return $container;
};
