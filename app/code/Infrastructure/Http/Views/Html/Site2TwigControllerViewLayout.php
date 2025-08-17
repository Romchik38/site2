<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Controller\Mappers\Breadcrumb\BreadcrumbInterface;
use Romchik38\Server\Http\Views\MetaDataInterface;
use Romchik38\Server\Http\Views\Traits\BreadcrumbControllerTrait;
use Twig\Environment;

class Site2TwigControllerViewLayout extends TwigControllerViewLayout
{
    use BreadcrumbControllerTrait;

    public function __construct(
        Environment $environment,
        protected BreadcrumbInterface $breadcrumbService,
        ?MetaDataInterface $metaDataService,
        string $layoutPath = 'base.twig',
    ) {
        parent::__construct($environment, $layoutPath, $metaDataService);
    }

    protected function beforeRender(array &$context): array
    {
        $context['breadrumb']         = $this->prepareBreadcrumbs();
        $context['static_urlbuilder'] = $this->createStaticUrlbuilder();
        return $context;
    }
}
