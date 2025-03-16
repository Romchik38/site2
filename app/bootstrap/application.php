<?php

declare(strict_types=1);

use Romchik38\Container\Promise;

return function ($container) {

    $configImg = require_once(__DIR__ . '/../config/shared/images.php');
    $configImgFolderFrontend =  $configImg['img-folder-frontend'] ??
        throw new RuntimeException('Missing config field: img-folder-frontend');

    $configAudio = require_once(__DIR__ . '/../config/shared/audio.php');
    $configAudioFolderFrontend =  $configAudio['audio-folder-frontend'] ??
        throw new RuntimeException('Missing config field: audio-folder-frontend');

    /** @todo waiting to refactor */
    // // ArticleListService
    // $container->add(
    //     \Romchik38\Site2\Application\ArticleList\ArticleListService::class,
    //     new \Romchik38\Site2\Application\ArticleList\ArticleListService(
    //         $container->get(\Romchik38\Site2\Domain\Article\ArticleRepositoryInterface::class),
    //         $container->get(\Romchik38\Server\Api\Models\SearchCriteria\SearchCriteriaFactoryInterface::class),
    //         $container->get(\Romchik38\Site2\Domain\Article\ArticleFilterFactoryInterface::class)
    //     )
    // );

    // ARTICLE LIST VIEW
    $container->shared(
        '\Romchik38\Site2\Application\ArticleListView\ArticleListViewService',
        [
            new Promise('\Romchik38\Site2\Application\ArticleListView\View\ArticleListViewRepositoryInterface'),
            new Promise('\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\SearchCriteriaFactory')
        ]
    );

    $container->shared('\Romchik38\Site2\Infrastructure\Persist\Sql\ReadModels\ArticleListView\SearchCriteriaFactory', []);

    $container->shared(
        '\Romchik38\Site2\Application\ArticleListView\View\ArticleDTOFactory',
        [
            new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
            new Promise('\Romchik38\Site2\Infrastructure\Services\ReadLengthFormatter')
        ]
    );
    $container->shared('\Romchik38\Site2\Application\ArticleListView\View\ImageDTOFactory', [$configImgFolderFrontend]);

    // ARTICLE VIEW
    $container->shared(
        '\Romchik38\Site2\Application\ArticleView\ArticleViewService',
        [
            new Promise('\Romchik38\Site2\Application\ArticleView\View\ArticleViewRepositoryInterface')
        ]
    );

    $container->shared('\Romchik38\Site2\Application\ArticleView\View\ArticleViewDTOFactory', [
        new Promise('\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat'),
        new Promise('\Romchik38\Server\Api\Services\Translate\TranslateInterface')
    ]);
    
    $container->shared('\Romchik38\Site2\Application\ArticleView\View\ImageDTOFactory', [$configImgFolderFrontend]);
    $container->shared('\Romchik38\Site2\Application\ArticleView\View\AudioDTOFactory', [$configAudioFolderFrontend]);

    // ADMIN USER CHECK
    $container->shared(
        '\Romchik38\Site2\Application\AdminUserCheck\AdminUserCheckService',
        [
            new Promise('\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface')
        ]
    );

    // ADMIN USER ROLES
    $container->shared(
        '\Romchik38\Site2\Application\AdminUserRoles\AdminUserRolesService',
        [
            new Promise('\Romchik38\Site2\Domain\AdminUser\AdminUserRepositoryInreface')
        ]
    );

    // User Check
    $container->shared('\Romchik38\Site2\Application\User\UserCheck\UserCheckService', []);

    return $container;
};
