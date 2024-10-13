<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html;

use Romchik38\Server\Api\Services\DynamicRoot\DynamicRootInterface;
use Romchik38\Server\Api\Services\SitemapInterface;
use Romchik38\Server\Api\Services\Translate\TranslateInterface;
use Romchik38\Server\Views\Errors\CantCreateViewException;
use Twig\Environment;

final class Site2TwigView extends TwigView
{

    public function __construct(
        protected readonly Environment $environment,
        /** Metadata Service here */
        protected readonly DynamicRootInterface|null $dynamicRootService,
        protected readonly TranslateInterface|null $translateService,
        protected readonly string $layoutPath = 'base.twig',
    ) {}

    protected function prepareMetaData(): void
    {
        $this->prepareLanguages();
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
}
