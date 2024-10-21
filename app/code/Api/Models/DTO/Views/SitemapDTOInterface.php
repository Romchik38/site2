<?php

declare(strict_types=1);

namespace Romchik38\Site2\Api\Models\DTO\Views;

use Romchik38\Server\Api\Models\DTO\DefaultView\DefaultViewDTOInterface;

/** 
 * SitemapDTOFactoryInterface is responsible to create an entity 
 * 
 * @api
 * */
interface SitemapDTOInterface extends DefaultViewDTOInterface
{
    const OUTPUT_FIELD = 'output';

    /**
     * @return string html link tree
     */
    public function getOutput(): string;
}
