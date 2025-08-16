<?php

declare(strict_types=1);

namespace Romchik38\Site2\Infrastructure\Http\Views\Html;

use Romchik38\Server\Http\Routers\Handlers\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Http\Utils\Urlbuilder\UrlbuilderInterface;
use Romchik38\Server\Http\Views\AbstractMetaData;
use Romchik38\Server\Utils\Translate\TranslateInterface;
use Romchik38\Site2\Application\VisitorServiceInterface;
use Romchik38\Site2\Infrastructure\Http\Views\Html\VO\QueryMetaData;

use function array_map;

class Site2Metadata extends AbstractMetaData
{
    public function __construct(
        protected readonly DynamicRootInterface $dynamicRootService,
        protected readonly VisitorServiceInterface $visitorService,
        TranslateInterface $translateService,
        UrlbuilderInterface $urlbuilder,
        string $imageFrontendPath,
    ) {
        $this->hash['image-frontend-path'] = $imageFrontendPath;
        $this->hash['query_metadata'] = new QueryMetaData();
        $this->hash['urlbuilder'] = $urlbuilder;
        $this->hash['translate'] = $translateService;
    }

    protected function beforeGetAll(): void
    {
        $this->prepareLanguages();
        $this->prepareVisitor();
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

        $this->hash['language']  = $currentRoot->getName();
        $this->hash['languages'] = $languages;
    }

    protected function prepareVisitor(): void
    {
        $visitor = $this->visitorService->getVisitor();
        $this->visitorService->clearMessage();
        $this->hash['visitor'] = $visitor;
    }
}
