<?php

declare(strict_types=1);

use Romchik38\Container;

return function (Container $container) {
    
    // MODEL FACTORIES
    $container->add(
        \Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory::class,
        new \Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\TranslateEntity\TranslateEntityModelFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\TranslateEntity\TranslateEntityModelFactory::class)
    );

    // DTO
    $container->add(
        \Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTOFactory::class,
        new \Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\DynamicRoot\DynamicRootDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\DynamicRoot\DynamicRootDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory::class,
        new \Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\TranslateEntity\TranslateEntityDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\TranslateEntity\TranslateEntityDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory::class,
        new \Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\DefaultView\DefaultViewDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\Controller\ControllerDTOFactory::class,
        new \Romchik38\Server\Models\DTO\Controller\ControllerDTOFactory
    );

    $container->add(
        \Romchik38\Server\Models\DTO\Http\Link\LinkDTOFactory::class,
        new \Romchik38\Server\Models\DTO\Http\Link\LinkDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Http\Link\LinkDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\Http\Link\LinkDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\Http\Breadcrumb\BreadcrumbDTOFactory::class,
        new \Romchik38\Server\Models\DTO\Http\Breadcrumb\BreadcrumbDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Http\Breadcrumb\BreadcrumbDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\Http\Breadcrumb\BreadcrumbDTOFactory::class)
    );

    $container->add(
        \Romchik38\Server\Models\DTO\Http\LinkTree\LinkTreeDTOFactory::class,
        new \Romchik38\Server\Models\DTO\Http\LinkTree\LinkTreeDTOFactory
    );
    $container->add(
        \Romchik38\Server\Api\Models\DTO\Http\LinkTree\LinkTreeDTOFactoryInterface::class,
        $container->get(\Romchik38\Server\Models\DTO\Http\LinkTree\LinkTreeDTOFactory::class)
    );

    // Services
    $container->add(
        \Romchik38\Server\Services\Mappers\Sitemap\Sitemap::class,
        new \Romchik38\Server\Services\Mappers\Sitemap\Sitemap(
            $container->get(\Romchik38\Server\Models\DTO\Controller\ControllerDTOFactory::class)
        )
    );
    $container->add(
        \Romchik38\Server\Api\Services\Mappers\SitemapInterface::class,
        $container->get(\Romchik38\Server\Services\Mappers\Sitemap\Sitemap::class)
    );

    // $container->add(
    //     \Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat::class,
    //     new \Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat
    // );
    // $container->add(
    //     \Romchik38\Site2\Application\ArticleListView\View\DateFormatterInterface::class,
    //     $container->get(\Romchik38\Site2\Infrastructure\Services\DateFormatterUsesDateFormat::class)
    // );

    // Controller
    $container->add(
        \Romchik38\Server\Routers\Http\ControllersCollection::class,
        new \Romchik38\Server\Routers\Http\ControllersCollection
    );
    $container->add(
        \Romchik38\Server\Api\Routers\Http\ControllersCollectionInterface::class,
        $container->get(\Romchik38\Server\Routers\Http\ControllersCollection::class)
    );

    $container->add(
        \Romchik38\Server\Results\Controller\ControllerResultFactory::class,
        new \Romchik38\Server\Results\Controller\ControllerResultFactory
    );
    $container->add(
        \Romchik38\Server\Api\Results\Controller\ControllerResultFactoryInterface::class,
        $container->get(\Romchik38\Server\Results\Controller\ControllerResultFactory::class)
    );

    return $container;
};
