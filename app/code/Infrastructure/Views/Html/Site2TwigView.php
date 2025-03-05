<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Views\Html;

use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Services\Mappers\Breadcrumb\Http\Breadcrumb;
use Romchik38\Server\Services\Urlbuilder\UrlbuilderInterface;
use Twig\Environment;

class Site2TwigView extends TwigView
{

    public function __construct(
        protected readonly Environment $environment,
        protected readonly TranslateInterface $translateService,
        /** Metadata Service here */
        protected readonly DynamicRootInterface $dynamicRootService,
        protected Breadcrumb $breadcrumbService,
        protected readonly UrlbuilderInterface $urlbuilder,
        protected readonly string $layoutPath = 'base.twig'
    ) {}

    protected function prepareMetaData(): void
    {
        $this->prepareLanguages();
        $this->prepareBreadcrumbs();
    }

    /**
     * Add to metadata:
     *   - current language
     *   - a list of available languages
     */
    protected function prepareLanguages(): void
    {
        $currentRoot = $this->dynamicRootService->getCurrentRoot();
        $languages = array_map(
            fn($item) => $item->getName(), 
            $this->dynamicRootService->getRootList()
        );

        $this->setMetadata('language', $currentRoot->getName())
            ->setMetadata('languages', $languages);
    }

    /**
     * @throws CantCreateViewException - If controller was not set
     */
    protected function prepareBreadcrumbs(): void {
        if($this->controller === null) {
            throw new CantCreateViewException('Can\'t prepare breadcrums: controller was not set');
        }
        
        $breadcrumbDTO = $this->breadcrumbService->getBreadcrumbDTO(
            $this->controller, 
            $this->action
        );
        $items = [];
        $stop = false;
        $current = $breadcrumbDTO;
        while($stop === false) {
            $stop = true;
            array_unshift($items, $current);
            $next = $current->getPrev();
            if($next !== null) {
                $stop = false;
                $current = $next;
            }
        }
        $this->setMetadata('breadrumb', $items);
    }

    /** 
     * @param array<string,mixed> &$context Twig context
     * @return array<string,mixed> Twig context
     */
    protected function beforeRender(array &$context): array
    {
        $context['translate'] = $this->translateService;
        $context['urlbuilder'] = $this->urlbuilder;
        return $context;
    }
}