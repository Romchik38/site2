<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html;

final class Site2TwigView extends TwigView {
    
    protected function prepareMetaData(): void
    {
        $this->setMetadata('language', $this->dynamicRootService->getCurrentRoot()->getName());   
    }
}