<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Controller\Mappers\Breadcrumb\Breadcrumb;
use Romchik38\Server\Http\Controller\Path;
use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\StaticUrlbuilder;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\VisitorServiceInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\VO\QueryMetaData;
use Twig\Environment;

use function array_map;
use function array_unshift;

/** @todo remove */
class Site2TwigViewLayout extends TwigViewLayout
{
    public function __construct(
        Environment $environment,
        protected readonly TranslateInterface $translateService,
        protected readonly DynamicRootInterface $dynamicRootService,
        protected Breadcrumb $breadcrumbService,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly string $imageFrontendPath,
        protected readonly VisitorServiceInterface $visitorService,
        string $layoutPath = 'base.twig'
    ) {
        parent::__construct($environment, $layoutPath);
    }

    protected function prepareMetaData(): void
    {
        $this->prepareLanguages();
        $this->prepareBreadcrumbs();
        $this->prepareSearch();
        $this->prepareVisitor();
        $this->setMetadata('image-frontend-path', $this->imageFrontendPath);
        $this->prepareStaticUrlbuilder();
    }

    /**
     * Add to metadata:
     *   - current language
     *   - a list of available languages
     */
    protected function prepareLanguages(): void
    {
        $currentRoot = $this->dynamicRootService->getCurrentRoot();
        $languages   = array_map(
            fn($item) => $item->getName(),
            $this->dynamicRootService->getRootList()
        );

        $this->setMetadata('language', $currentRoot->getName())
            ->setMetadata('languages', $languages);
    }

    /**
     * @throws CantCreateViewException - If controller was not set.
     */
    protected function prepareBreadcrumbs(): void
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
        $this->setMetadata('breadrumb', $items);
    }

    /** @todo move to frontend metadata service */
    protected function prepareSearch(): void
    {
        $this->setMetadata('query_metadata', new QueryMetaData());
    }

    protected function prepareVisitor(): void
    {
        $visitor = $this->visitorService->getVisitor();
        $this->visitorService->clearMessage();
        $this->setMetadata('visitor', $visitor);
    }

    protected function prepareStaticUrlbuilder(): void
    {
        if ($this->controller === null) {
            throw new CantCreateViewException('Can\'t prepare static urlbuilder: controller was not set');
        }
        $path             = new Path($this->controller->getFullPath($this->action));
        $staticUrlbuilder = new StaticUrlbuilder($path);
        $this->setMetadata('static_urlbuilder', $staticUrlbuilder);
    }

    /**
     * @param array<string,mixed> &$context Twig context
     * @return array<string,mixed> Twig context
     */
    protected function beforeRender(array &$context): array
    {
        $context['translate']  = $this->translateService;
        $context['urlbuilder'] = $this->urlbuilder;
        return $context;
    }
}
