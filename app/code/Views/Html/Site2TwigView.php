<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html;

use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Services\Breadcrumb\Http\Breadcrumb;
use Romchik38\Server\Views\Errors\CantCreateViewException;
use Twig\Environment;

final class Site2TwigView extends TwigView
{

    public function __construct(
        protected readonly Environment $environment,
        protected readonly TranslateInterface $translateService,
        /** Metadata Service here */
        protected readonly DynamicRootInterface|null $dynamicRootService,
        protected Breadcrumb $breadcrumbService,
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
        /** 1. Check DynamicRoot */
        if ($this->dynamicRootService === null) {
            throw new CantCreateViewException(
                sprintf('%s: Missing DynamicRootInterface', Site2TwigView::class)
            );
        }

        /** 2. Set languages */
        $currentRoot = $this->dynamicRootService->getCurrentRoot();
        $languages = array_map(fn($item) => $item->getName(), $this->dynamicRootService->getRootList());

        $this->setMetadata('language', $currentRoot->getName())
            ->setMetadata('languages', $languages);
    }

    protected function prepareBreadcrumbs(): void {
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
        return $context;
    }
}