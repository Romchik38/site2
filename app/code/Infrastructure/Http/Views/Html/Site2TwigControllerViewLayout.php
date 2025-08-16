<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb;
use Romchik38\Server\Http\Controller\Mappers\Breadcrumb\BreadcrumbDTOInterface;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Utils\Urlbuilder\StaticUrlbuilder;
use Romchik38\Server\Http\Utils\Urlbuilder\StaticUrlbuilderInterface;
use Romchik38\Server\Http\Views\MetaDataInterface;
use Twig\Environment;

use function array_unshift;

class Site2TwigControllerViewLayout extends TwigControllerViewLayout
{
    public function __construct(
        Environment $environment,
        /** @todo move to server AbstractControllerView */
        protected Breadcrumb $breadcrumbService,
        ?MetaDataInterface $metaDataService,
        string $layoutPath = 'base.twig',
    ) {
        parent::__construct($environment, $layoutPath, $metaDataService);
    }

    /**
     * @todo move to AbstractControllerView
     * 
     * @throws CantCreateViewException - If controller was not set.
     * @return array<int,BreadcrumbDTOInterface>
     */
    protected function prepareBreadcrumbs(): array
    {
        if ($this->controller === null) {
            throw new CantCreateViewException('Can\'t prepare breadcrums: controller was not set');
        }

        $breadcrumbDto = $this->breadcrumbService->getBreadcrumbDTO(
            $this->controller,
            $this->action
        );
        $items         = [];
        $stop          = false;
        $current       = $breadcrumbDto;
        while ($stop === false) {
            $stop = true;
            array_unshift($items, $current);
            $next = $current->getPrev();
            if ($next !== null) {
                $stop    = false;
                $current = $next;
            }
        }
        return $items;
    }

    /** 
     * @todo move to AbstractControllerView 
     * 
     * @throws CantCreateViewException
     * */
    protected function prepareStaticUrlbuilder(): StaticUrlbuilderInterface
    {
        if ($this->controller === null) {
            throw new CantCreateViewException('Can\'t prepare static urlbuilder: controller was not set');
        }
        $path = new Path($this->controller->getFullPath($this->action));
        return new StaticUrlbuilder($path);
    }

    /**
     * @param array<string,mixed> &$context Twig context
     * @return array<string,mixed> Twig context
     */
    protected function beforeRender(array &$context): array
    {
        $context['breadrumb']  = $this->prepareBreadcrumbs();
        $context['static_urlbuilder'] = $this->prepareStaticUrlbuilder();
        return $context;
    }
}
