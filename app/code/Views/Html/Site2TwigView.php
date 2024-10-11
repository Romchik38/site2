<?php

declare(strict_types=1);

namespace Romchik38\Site2\Views\Html;

use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

final class Site2TwigView extends TwigView {
    
    protected function prepareMetaData(): void
    {

        /** 
         *   1. add to array $this->metaData key/value
         *   2. meta_data will be avalible in a template
         * */
    }
}